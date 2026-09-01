<?php

namespace Yungifez\AprilUI;

use RuntimeException;

/**
 * Reads the component registry shipped with April UI.
 */
class Registry
{
    /** @var array<string, array<string, mixed>> */
    protected array $manifest;

    protected string $sourcePath;

    public function __construct(?string $manifestPath = null, ?string $sourcePath = null)
    {
        $manifestPath ??= config('april-ui.registry.path', dirname(__DIR__).'/resources/registry.json');
        $sourcePath ??= config('april-ui.registry.source', dirname(__DIR__).'/resources/views/components');

        if (! is_file($manifestPath)) {
            throw new RuntimeException("April UI registry not found at {$manifestPath}.");
        }

        $manifest = json_decode((string) file_get_contents($manifestPath), true);

        if (! is_array($manifest)) {
            throw new RuntimeException("April UI registry at {$manifestPath} is not valid JSON.");
        }

        $this->manifest = $manifest;
        $this->sourcePath = rtrim($sourcePath, '/');
    }

    /** @return array<string, array<string, mixed>> */
    public function manifest(): array
    {
        return $this->manifest;
    }

    /** @return list<string> */
    public function names(): array
    {
        $names = array_keys($this->manifest);
        sort($names);

        return $names;
    }

    public function familyExists(string $name): bool
    {
        return array_key_exists($name, $this->manifest);
    }

    /** @return list<string> */
    public function filesFor(string $name): array
    {
        return array_map(
            fn (string $file): string => $this->sourcePath.'/'.ltrim($file, '/'),
            $this->manifest[$name]['files'] ?? []
        );
    }

    /** @return list<string> */
    public function dependenciesFor(string $name): array
    {
        return $this->manifest[$name]['dependencies'] ?? [];
    }

    /** @return array{composer?: list<string>, npm?: list<string>} */
    public function packagesFor(string $name): array
    {
        return $this->manifest[$name]['packages'] ?? [];
    }

    /** @return list<string> */
    public function resolve(string $name, array &$resolved = []): array
    {
        if (! $this->familyExists($name) || in_array($name, $resolved, true)) {
            return $resolved;
        }

        $resolved[] = $name;

        foreach ($this->dependenciesFor($name) as $dependency) {
            $this->resolve($dependency, $resolved);
        }

        sort($resolved);

        return $resolved;
    }

    public function sourcePath(): string
    {
        return $this->sourcePath;
    }
}
