<?php

namespace Yungifez\AprilUI\Console\Commands;

use Illuminate\Console\Command;
use JsonException;

class McpInstallCommand extends Command
{
    protected $signature = 'april:mcp:install
        {--config=.mcp.json : The MCP configuration file to update}
        {--force : Replace an existing April UI server definition}';

    protected $description = 'Add the April UI MCP server to an MCP client configuration';

    public function handle(): int
    {
        $path = $this->resolveConfigPath();

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

        if (! $this->writeConfiguration($path, $configuration)) {
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
    protected function writeConfiguration(string $path, array $configuration): bool
    {
        $directory = dirname($path);

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            return false;
        }

        try {
            $contents = json_encode(
                $configuration,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
            ).PHP_EOL;
        } catch (JsonException) {
            return false;
        }

        return file_put_contents($path, $contents) !== false;
    }

    protected function resolveConfigPath(): string
    {
        $path = (string) $this->option('config');

        if ($path === '') {
            $path = '.mcp.json';
        }

        if (str_starts_with($path, DIRECTORY_SEPARATOR) || preg_match('/^[A-Za-z]:[\\\\\/]/', $path) === 1) {
            return $path;
        }

        return base_path($path);
    }
}
