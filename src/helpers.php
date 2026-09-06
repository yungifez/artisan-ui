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

if (! function_exists('aprilHeadingLevel')) {
    /**
     * Read the heading level a component renders its title as.
     *
     * A document may only hold levels 1 to 6. Anything else falls back to the
     * component default.
     */
    function aprilHeadingLevel(mixed $level, int $default = 2): int
    {
        $level = is_numeric($level) ? (int) $level : 0;

        return $level >= 1 && $level <= 6 ? $level : $default;
    }
}
