<?php

declare(strict_types=1);

namespace Yungifez\AprilUI\Support;

use TalesFromADev\TailwindMerge\TailwindMergeInterface;

/**
 * Adapts the framework agnostic TailwindMerge library to the argument shapes
 * the April UI Blade components use.
 *
 * The library accepts a flat list of strings. The components also pass arrays
 * and conditional maps, so this class flattens the arguments first.
 */
class TailwindMerger
{
    public function __construct(protected TailwindMergeInterface $merger) {}

    /**
     * Merge the given classes and resolve conflicts.
     *
     * @param  string|array<array-key, string|bool>|null  ...$args
     */
    public function merge(...$args): string
    {
        $classes = $this->flatten($args);

        if ($classes === []) {
            return '';
        }

        return $this->merger->merge(...$classes);
    }

    /**
     * Flatten mixed arguments into a list of class strings.
     *
     * A string key is used as the class name when its value is truthy. This
     * supports the conditional syntax: ['hidden' => $isHidden].
     *
     * @param  iterable<array-key, mixed>  $args
     * @return list<string>
     */
    protected function flatten(iterable $args): array
    {
        $classes = [];

        foreach ($args as $key => $value) {
            if (is_string($key)) {
                if ($value) {
                    $classes[] = $key;
                }

                continue;
            }

            if (is_iterable($value)) {
                $classes = array_merge($classes, $this->flatten($value));

                continue;
            }

            if ($value === null || $value === false || $value === '') {
                continue;
            }

            $classes[] = (string) $value;
        }

        return $classes;
    }
}
