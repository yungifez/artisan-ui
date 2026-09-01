<?php

declare(strict_types=1);

/**
 * Build resources/registry.json from the package Blade views.
 *
 * The view directory remains the source of truth. This file adds dependency
 * information for the CLI and MCP server without changing Laravel resolution.
 */
$root = dirname(__DIR__);
$source = $root.'/resources/views/components';
$destination = $root.'/resources/registry.json';
$files = glob($source.'/*.blade.php') ?: [];
$known = array_map(fn (string $file): string => basename($file, '.blade.php'), $files);
$known = array_flip($known);
$registry = [];

foreach ($files as $file) {
    $name = basename($file, '.blade.php');
    $contents = (string) file_get_contents($file);
    $dependencies = [];

    preg_match_all('/<april:([a-z0-9-]+)/i', $contents, $matches);
    foreach (array_unique($matches[1] ?? []) as $dependency) {
        if ($dependency !== $name && isset($known[$dependency])) {
            $dependencies[] = $dependency;
        }
    }
    sort($dependencies);

    $packages = [];
    if (str_contains($contents, 'twMerge')) {
        $packages['composer'][] = 'tales-from-a-dev/tailwind-merge-php';
    }
    if (preg_match('/<x-lucide-[a-z0-9-]+/i', $contents)) {
        $packages['composer'][] = 'mallardduck/blade-lucide-icons';
    }
    if ($name === 'editor') {
        $packages['npm'] = [
            '@tiptap/core',
            '@tiptap/extension-placeholder',
            '@tiptap/starter-kit',
        ];
    }
    if ($name === 'date-picker') {
        $packages['npm'] = ['date-fns'];
    }

    $registry[$name] = [
        'name' => $name,
        'files' => [$name.'.blade.php'],
        'dependencies' => $dependencies,
        'packages' => $packages,
    ];
}

uksort($registry, 'strnatcasecmp');
file_put_contents($destination, json_encode($registry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");
echo 'Built '.count($registry)." registry entries.\n";
