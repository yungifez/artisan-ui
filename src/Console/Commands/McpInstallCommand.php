<?php

namespace Yungifez\AprilUI\Console\Commands;

use Illuminate\Console\Command;
use JsonException;

class McpInstallCommand extends Command
{
    protected $signature = 'april:mcp:install
        {--config=.mcp.json : The MCP configuration file to update}
        {--codex : Update Codex\'s project configuration at .codex/config.toml}
        {--force : Replace an existing April UI server definition}';

    protected $description = 'Add the April UI MCP server to an MCP client configuration';

    public function handle(): int
    {
        $path = $this->resolveConfigPath();

        if ($this->isCodexConfiguration($path)) {
            return $this->installCodexConfiguration($path);
        }

        return $this->installJsonConfiguration($path);
    }

    protected function installJsonConfiguration(string $path): int
    {
        try {
            $configuration = $this->readConfiguration($path);
        } catch (JsonException $exception) {
            $this->error("The MCP configuration at {$path} is not valid JSON: {$exception->getMessage()}");

            return self::FAILURE;
        }

        $serversKey = $this->serversKey($configuration);

        if (isset($configuration[$serversKey]) && ! is_array($configuration[$serversKey])) {
            $this->error("The [{$serversKey}] value in {$path} must be an object.");

            return self::FAILURE;
        }

        $configuration[$serversKey] ??= [];

        if (array_key_exists('april-ui', $configuration[$serversKey]) && ! $this->option('force')) {
            $this->components->warn("April UI is already configured in {$path}. Use --force to replace it.");

            return self::SUCCESS;
        }

        $configuration[$serversKey]['april-ui'] = $this->serverDefinition();

        if (! $this->writeFile($path, $this->encodeJson($configuration))) {
            $this->error("Unable to write the MCP configuration at {$path}.");

            return self::FAILURE;
        }

        $this->components->info("April UI MCP server added to {$path}.");

        return self::SUCCESS;
    }

    protected function installCodexConfiguration(string $path): int
    {
        $configuration = is_file($path) ? (string) file_get_contents($path) : '';
        $section = '[mcp_servers.april-ui]';

        if (preg_match('/^\[mcp_servers\.april-ui\]\s*$/m', $configuration) === 1 && ! $this->option('force')) {
            $this->components->warn("April UI is already configured in {$path}. Use --force to replace it.");

            return self::SUCCESS;
        }

        $definition = $this->codexServerDefinition();

        if (str_contains($configuration, $section)) {
            $configuration = (string) preg_replace(
                '/^\[mcp_servers\.april-ui\]\s*\R.*?(?=^\[[^\]\r\n]+\]\s*$|\z)/ms',
                $definition,
                $configuration,
                1,
            );
        } else {
            $configuration = trim($configuration) === ''
                ? $definition
                : rtrim($configuration).PHP_EOL.PHP_EOL.$definition;
        }

        if (! $this->writeFile($path, $configuration)) {
            $this->error("Unable to write the MCP configuration at {$path}.");

            return self::FAILURE;
        }

        $this->components->info("April UI MCP server added to {$path}.");

        return self::SUCCESS;
    }

    /** @return array<string, mixed> */
    protected function readConfiguration(string $path): array
    {
        if (! is_file($path) || trim((string) file_get_contents($path)) === '') {
            return [];
        }

        $configuration = json_decode(
            (string) file_get_contents($path),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );

        if (! is_array($configuration)) {
            throw new JsonException('The root value must be an object.');
        }

        return $configuration;
    }

    /** @param array<string, mixed> $configuration */
    protected function serversKey(array $configuration): string
    {
        if (array_key_exists('mcpServers', $configuration)) {
            return 'mcpServers';
        }

        if (array_key_exists('servers', $configuration)) {
            return 'servers';
        }

        return 'mcpServers';
    }

    /** @return array{command: string, args: list<string>} */
    protected function serverDefinition(): array
    {
        $sail = base_path('vendor/bin/sail');

        return [
            'command' => is_file($sail) ? 'vendor/bin/sail' : 'php',
            'args' => ['artisan', 'april:mcp'],
        ];
    }

    /** @param array<string, mixed> $configuration */
    protected function encodeJson(array $configuration): string
    {
        try {
            return json_encode(
                $configuration,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
            ).PHP_EOL;
        } catch (JsonException) {
            return '';
        }
    }

    protected function codexServerDefinition(): string
    {
        $command = is_file(base_path('vendor/bin/sail')) ? 'vendor/bin/sail' : 'php';

        return '[mcp_servers.april-ui]'.PHP_EOL
            .'command = '.json_encode($command).PHP_EOL
            .'args = ["artisan", "april:mcp"]'.PHP_EOL;
    }

    protected function writeFile(string $path, string $contents): bool
    {
        $directory = dirname($path);

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            return false;
        }

        return file_put_contents($path, $contents) !== false;
    }

    protected function resolveConfigPath(): string
    {
        $path = (string) $this->option('config');

        if ($this->option('codex') && $path === '.mcp.json') {
            $path = '.codex/config.toml';
        }

        if ($path === '') {
            $path = '.mcp.json';
        }

        if (str_starts_with($path, DIRECTORY_SEPARATOR) || preg_match('/^[A-Za-z]:[\\\\\/]/', $path) === 1) {
            return $path;
        }

        return base_path($path);
    }

    protected function isCodexConfiguration(string $path): bool
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'toml';
    }
}
