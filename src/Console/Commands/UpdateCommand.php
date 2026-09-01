<?php

namespace Yungifez\AprilUI\Console\Commands;

use Illuminate\Console\Command;
use Yungifez\AprilUI\Registry;

class UpdateCommand extends Command
{
    protected $signature = 'april:update
        {components?* : Published components to compare}
        {--dry-run : Show changes without writing}
        {--diff : Show changed lines}
        {--force : Replace files without prompting}
        {--no-backup : Do not create .bak files}
        {--ignore-whitespace : Ignore whitespace-only changes}';

    protected $description = 'Compare published April UI components with the package';

    public function handle(Registry $registry): int
    {
        $target = base_path(config('april-ui.registry.publish_path', 'resources/views/vendor/april/components'));
        $requested = (array) $this->argument('components');
        $families = $requested === [] ? $registry->names() : $requested;
        $changed = [];

        foreach ($families as $family) {
            if (! $registry->familyExists($family)) {
                $this->components->error("Unknown component: {$family}");

                return self::FAILURE;
            }

            foreach ($registry->filesFor($family) as $source) {
                $destination = $target.'/'.basename($source);
                if (! is_file($destination)) {
                    continue;
                }

                $local = (string) file_get_contents($destination);
                $package = (string) file_get_contents($source);
                if ($this->same($local, $package)) {
                    continue;
                }

                $changed[$destination] = [$local, $package];
            }
        }

        if ($changed === []) {
            $this->components->info('All published components are up to date.');

            return self::SUCCESS;
        }

        foreach ($changed as $destination => [$local, $package]) {
            $label = $this->relative($destination);
            $this->line('~ '.$label);

            if ($this->option('diff')) {
                $this->renderDiff($local, $package, $label);
            }

            if ($this->option('dry-run')) {
                continue;
            }

            if (! $this->option('force') && (! $this->input->isInteractive() || ! $this->confirm('  Replace this published file?', false))) {
                $this->line('  Kept published file. Use --force to replace it.');

                continue;
            }

            if (! $this->option('no-backup')) {
                copy($destination, $destination.'.bak');
            }

            file_put_contents($destination, $package);
        }

        if ($this->option('dry-run')) {
            $this->components->info('Dry run complete. No files were written.');
        }

        return self::SUCCESS;
    }

    protected function same(string $local, string $package): bool
    {
        if (! $this->option('ignore-whitespace')) {
            return $local === $package;
        }

        return preg_replace('/\s+/', '', $local) === preg_replace('/\s+/', '', $package);
    }

    protected function relative(string $path): string
    {
        return ltrim(str_replace('\\', '/', str_replace(base_path(), '', $path)), '/');
    }

    protected function renderDiff(string $local, string $package, string $label): void
    {
        $before = explode("\n", $local);
        $after = explode("\n", $package);
        $this->line("  --- {$label} (published)");
        $this->line("  +++ {$label} (package)");

        foreach (array_diff_assoc($before, $after) as $line) {
            $this->line('  -'.$line);
        }
        foreach (array_diff_assoc($after, $before) as $line) {
            $this->line('  +'.$line);
        }
    }
}
