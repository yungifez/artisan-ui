<?php

namespace Yungifez\AprilUI\Console\Commands;

use Illuminate\Console\Command;
use Yungifez\AprilUI\Registry;

class ListCommand extends Command
{
    protected $signature = 'april:list {component? : Show details for one component}';

    protected $description = 'List April UI components and their dependencies';

    public function handle(Registry $registry): int
    {
        $name = $this->argument('component');

        if ($name !== null) {
            if (! $registry->familyExists($name)) {
                $this->components->error("Unknown component: {$name}");

                return self::FAILURE;
            }

            $entry = $registry->manifest()[$name];
            $this->components->info($name);
            $this->line('  Files: '.implode(', ', $entry['files'] ?? []));
            $this->line('  Dependencies: '.(implode(', ', $entry['dependencies'] ?? []) ?: 'none'));

            foreach ($registry->packagesFor($name) as $type => $packages) {
                if ($packages !== []) {
                    $this->line('  '.ucfirst($type).': '.implode(', ', $packages));
                }
            }

            return self::SUCCESS;
        }

        $rows = [];
        foreach ($registry->names() as $component) {
            $entry = $registry->manifest()[$component];
            $rows[] = [$component, count($entry['files'] ?? []), implode(', ', $entry['dependencies'] ?? []) ?: '—'];
        }

        $this->table(['Component', 'Files', 'Dependencies'], $rows);
        $this->line(count($rows).' component families available.');

        return self::SUCCESS;
    }
}
