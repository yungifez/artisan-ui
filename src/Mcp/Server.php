<?php

namespace Yungifez\AprilUI\Mcp;

use Yungifez\AprilUI\Registry;

/**
 * Small, dependency-free MCP server for April UI.
 *
 * The server uses newline-delimited JSON-RPC over standard input and output.
 */
class Server
{
    public function __construct(
        protected Registry $registry,
        protected string $basePath,
    ) {}

    /** @param array<string, mixed> $request */
    public function handle(array $request): ?array
    {
        if (! array_key_exists('id', $request)) {
            return null;
        }

        $id = $request['id'];
        $method = $request['method'] ?? '';
        $params = is_array($request['params'] ?? null) ? $request['params'] : [];

        try {
            $result = match ($method) {
                'initialize' => $this->initialize(),
                'ping' => new \stdClass,
                'tools/list' => ['tools' => $this->tools()],
                'tools/call' => $this->callTool($params),
                'resources/list' => ['resources' => $this->resources()],
                'resources/read' => ['contents' => [$this->readResource((string) ($params['uri'] ?? ''))]],
                default => throw new McpError(-32601, "Method not found: {$method}"),
            };

            return ['jsonrpc' => '2.0', 'id' => $id, 'result' => $result];
        } catch (McpError $error) {
            return [
                'jsonrpc' => '2.0',
                'id' => $id,
                'error' => ['code' => $error->errorCode, 'message' => $error->getMessage()],
            ];
        } catch (\Throwable $error) {
            return [
                'jsonrpc' => '2.0',
                'id' => $id,
                'error' => ['code' => -32603, 'message' => $error->getMessage()],
            ];
        }
    }

    /** @param resource $input @param resource $output */
    public function run($input, $output): int
    {
        while (($line = fgets($input)) !== false) {
            $request = json_decode(trim($line), true);
            if (! is_array($request)) {
                fwrite($output, json_encode([
                    'jsonrpc' => '2.0',
                    'id' => null,
                    'error' => ['code' => -32700, 'message' => 'Invalid JSON'],
                ], JSON_UNESCAPED_SLASHES)."\n");

                continue;
            }

            $response = $this->handle($request);
            if ($response !== null) {
                fwrite($output, json_encode($response, JSON_UNESCAPED_SLASHES)."\n");
                fflush($output);
            }
        }

        return 0;
    }

    /** @return array<string, mixed> */
    protected function initialize(): array
    {
        return [
            'protocolVersion' => '2024-11-05',
            'capabilities' => ['tools' => new \stdClass, 'resources' => ['subscribe' => false]],
            'serverInfo' => [
                'name' => config('april-ui.mcp.name', 'april-ui'),
                'version' => config('april-ui.mcp.version', '1.0.0'),
            ],
        ];
    }

    /** @return list<array<string, mixed>> */
    protected function tools(): array
    {
        return [
            [
                'name' => 'april_list',
                'description' => 'List April UI components or inspect one component.',
                'inputSchema' => ['type' => 'object', 'properties' => ['component' => ['type' => 'string']]],
            ],
            [
                'name' => 'april_search',
                'description' => 'Search April UI component names and descriptions.',
                'inputSchema' => ['type' => 'object', 'required' => ['query'], 'properties' => ['query' => ['type' => 'string']]],
            ],
            [
                'name' => 'april_publish',
                'description' => 'Publish selected April UI components to Laravel’s vendor view path.',
                'inputSchema' => [
                    'type' => 'object',
                    'required' => ['components'],
                    'properties' => [
                        'components' => ['type' => 'array', 'items' => ['type' => 'string']],
                        'force' => ['type' => 'boolean'],
                    ],
                ],
            ],
        ];
    }

    /** @return list<array<string, string>> */
    protected function resources(): array
    {
        return array_map(fn (string $name): array => [
            'uri' => 'april://component/'.$name,
            'name' => $name,
            'description' => 'Blade source for the '.$name.' component.',
            'mimeType' => 'text/plain',
        ], $this->registry->names());
    }

    /** @param array<string, mixed> $params @return array<string, mixed> */
    protected function callTool(array $params): array
    {
        $name = $params['name'] ?? '';
        $arguments = is_array($params['arguments'] ?? null) ? $params['arguments'] : [];

        $payload = match ($name) {
            'april_list' => $this->list($arguments['component'] ?? null),
            'april_search' => $this->search((string) ($arguments['query'] ?? '')),
            'april_publish' => $this->publish($arguments),
            default => throw new McpError(-32602, "Unknown tool: {$name}"),
        };

        return [
            'content' => [['type' => 'text', 'text' => json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)]],
            'structuredContent' => $payload,
        ];
    }

    /** @return array<string, mixed> */
    protected function list(?string $component): array
    {
        if ($component !== null && ! $this->registry->familyExists($component)) {
            throw new McpError(-32602, "Unknown component: {$component}");
        }

        if ($component !== null) {
            return $this->registry->manifest()[$component];
        }

        return ['components' => $this->registry->names()];
    }

    /** @return array<string, mixed> */
    protected function search(string $query): array
    {
        $query = strtolower(trim($query));
        $matches = array_values(array_filter($this->registry->names(), fn (string $name): bool => $query === '' || str_contains($name, $query)));

        return ['query' => $query, 'components' => $matches];
    }

    /** @param array<string, mixed> $arguments @return array<string, mixed> */
    protected function publish(array $arguments): array
    {
        $components = $arguments['components'] ?? [];
        if (! is_array($components) || $components === []) {
            throw new McpError(-32602, 'components must be a non-empty array.');
        }

        $resolved = [];
        foreach ($components as $component) {
            if (! is_string($component) || ! $this->registry->familyExists($component)) {
                throw new McpError(-32602, "Unknown component: {$component}");
            }
            $this->registry->resolve($component, $resolved);
        }

        $target = $this->basePath.'/'.trim(config('april-ui.registry.publish_path', 'resources/views/vendor/april/components'), '/');
        if (! is_dir($target)) {
            mkdir($target, 0755, true);
        }

        $written = [];
        $skipped = [];
        foreach ($resolved as $component) {
            foreach ($this->registry->filesFor($component) as $source) {
                $destination = $target.'/'.basename($source);
                if (is_file($destination) && ! ($arguments['force'] ?? false)) {
                    $skipped[] = $destination;

                    continue;
                }
                copy($source, $destination);
                $written[] = $destination;
            }
        }

        return ['written' => $written, 'skipped' => $skipped];
    }

    /** @return array{uri: string, mimeType: string, text: string} */
    protected function readResource(string $uri): array
    {
        if (! preg_match('#^april://component/([a-z0-9-]+)$#', $uri, $matches) || ! $this->registry->familyExists($matches[1])) {
            throw new McpError(-32602, "Unknown resource: {$uri}");
        }

        $files = array_map(fn (string $path): string => "// {$path}\n".(string) file_get_contents($path), $this->registry->filesFor($matches[1]));

        return ['uri' => $uri, 'mimeType' => 'text/plain', 'text' => implode("\n\n", $files)];
    }
}
