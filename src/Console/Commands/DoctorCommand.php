<?php

namespace Yungifez\AprilUI\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class DoctorCommand extends Command
{
    protected $signature = 'april:doctor {path? : Blade directory to scan} {--compiled= : Compiled view directory}';

    protected $description = 'Find common April UI integration problems';

    public function handle(): int
    {
        $base = $this->argument('path') ?: resource_path('views');
        if (! is_dir($base)) {
            $this->components->error("Not a directory: {$base}");

            return self::FAILURE;
        }

        $findings = [];
        foreach ((new Finder)->files()->in($base)->name('*.blade.php') as $file) {
            $content = $this->maskComments($file->getContents());
            if (! preg_match_all('/<april:button\b[^>]*>/s', $content, $matches, PREG_OFFSET_CAPTURE)) {
                continue;
            }

            foreach ($matches[0] as [$tag, $offset]) {
                $before = substr($content, 0, $offset);
                if (substr_count($before, '<form') <= substr_count($before, '</form>')) {
                    continue;
                }
                if (! preg_match('/\btype\s*=|@click|x-on:click|wire:click/i', $tag)) {
                    $findings[] = $file->getRealPath().':'.(substr_count($before, "\n") + 1).' — button inside a form has no type.';
                }
            }
        }

        $compiled = $this->option('compiled') ?: (function_exists('storage_path') ? storage_path('framework/views') : null);
        if ($compiled && is_dir($compiled)) {
            foreach ((new Finder)->files()->in($compiled)->name('*.php') as $file) {
                if (preg_match('/<april:[a-z0-9-]+/i', $this->maskComments($file->getContents()))) {
                    $findings[] = $file->getRealPath().' — an April tag reached compiled output.';
                }
            }
        }

        if ($findings === []) {
            $this->components->info('No April UI integration problems found.');

            return self::SUCCESS;
        }

        $this->components->warn(count($findings).' possible problem(s) found:');
        foreach ($findings as $finding) {
            $this->line('  ⚠ '.$finding);
        }

        return self::FAILURE;
    }

    protected function maskComments(string $content): string
    {
        foreach ([
            '/\{\{--.*?--\}\}/s',
            '/<!--.*?-->/s',
            '/\/\*.*?\*\//s',
            '/(?<![:\/])\/\/[^\n]*/',
        ] as $pattern) {
            $content = preg_replace_callback(
                $pattern,
                fn (array $match): string => preg_replace('/[^\n]/', ' ', $match[0]),
                $content
            ) ?? $content;
        }

        return $content;
    }
}
