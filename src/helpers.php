<?php

declare(strict_types=1);

use Yungifez\AprilUI\Support\TailwindMerger;

if (! function_exists('twMerge')) {
    /**
     * Merge Tailwind CSS classes and resolve conflicts.
     *
     * Accepts strings, arrays of strings, and arrays that map a class name to a
     * boolean. Later classes win over earlier ones.
     *
     * @param  string|array<array-key, string|bool>  ...$args
     */
    function twMerge(...$args): string
    {
        return app(TailwindMerger::class)->merge(...$args);
    }
}
