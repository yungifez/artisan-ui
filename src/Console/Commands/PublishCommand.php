<?php

namespace Yungifez\AprilUI\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Yungifez\AprilUI\Registry;

class PublishCommand extends Command
{
    protected $signature = 'april:publish
        {components?* : Components to publish}
        {--all : Publish every component}
        {--force : Replace published files without prompting}';

    protected $description = 'Publish selected April UI components into Laravel’s vendor view path';

    public function handle(Registry $registry): int
    {
        $requested = $this->option('all') ? $registry->names() : (array) $this->argument('components');

        if ($requested === [] && $this->input->isInteractive()) {
            $requested = (array) $this->choice('Select components to publish', $registry->names(), null, null, true);
        }

        if ($requested === []) {
            $this->components->error('Specify a component or use --all.');

            return self::FAILURE;
        }

        $unknown = array_values(array_filter($requested, fn (string $name): bool => ! $registry->familyExists($name)));
        if ($unknown !== []) {
            $this->components->error('Unknown component(s): '.implode(', ', $unknown));

            return self::FAILURE;
        }

        $families = [];
        foreach ($requested as $name) {
            $registry->resolve($name, $families);
        }

        $exitCode = Artisan::call('vendor:publish', [
            '--tag' => array_map(fn (string $name): string => 'april-view-'.$name, $families),
            '--force' => (bool) $this->option('force'),
        ], $this->output);

        $this->line('Published files use Laravel’s normal resources/views/vendor/april path.');

        return $exitCode;
    }
}
