<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Blade;
use Yungifez\AprilUI\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

/*
|--------------------------------------------------------------------------
| The component registry
|--------------------------------------------------------------------------
|
| The Blade views remain the source of truth. The registry test checks that
| resources/registry.json stays in sync with that directory.
|
*/

/**
 * Absolute path to the component views.
 */
function componentPath(string $name = ''): string
{
    $base = realpath(__DIR__.'/../resources/views/components');

    return $name === '' ? $base : $base.'/'.$name.'.blade.php';
}

/**
 * Every component name, in kebab-case, sorted.
 *
 * @return list<string>
 */
function componentNames(): array
{
    $names = array_map(
        fn (string $file): string => basename($file, '.blade.php'),
        glob(componentPath().'/*.blade.php')
    );

    sort($names);

    return $names;
}

/**
 * Components whose view file is still empty.
 *
 * These are known work in progress. The registry test fails if a component not
 * on this list becomes empty, and it also fails if a component on this list
 * gets content. Remove the name here when you implement the component.
 *
 * @return list<string>
 */
function emptyComponents(): array
{
    return [];
}

/**
 * Component names that have content and therefore must render.
 *
 * @return list<string>
 */
function renderableComponentNames(): array
{
    return array_values(array_diff(componentNames(), emptyComponents()));
}

/**
 * Drop every compiled view.
 *
 * The asset directives bake the manifest hash into the compiled view, so a test
 * that checks the hash must compile the view again after a rebuild.
 */
function clearCompiledViews(): void
{
    Artisan::call('view:clear');
}

/**
 * Render a Blade string with the package syntax enabled.
 */
function render(string $template, array $data = []): string
{
    return Blade::render($template, $data);
}

/**
 * Render one component by name, with an optional attribute string and slot.
 */
function renderComponent(string $name, string $attributes = '', string $slot = ''): string
{
    $attributes = $attributes === '' ? '' : ' '.$attributes;

    return render("<april:{$name}{$attributes}>{$slot}</april:{$name}>");
}

/**
 * The class list of an element in a fragment of HTML.
 *
 * Reads the first element by default. Pass an index to read a later one, for a
 * component that wraps its main element.
 *
 * @return list<string>
 */
function classesOf(string $html, int $index = 0): array
{
    if (preg_match_all('/class="([^"]*)"/', $html, $matches) === 0) {
        return [];
    }

    if (! isset($matches[1][$index])) {
        return [];
    }

    return preg_split('/\s+/', trim($matches[1][$index]), -1, PREG_SPLIT_NO_EMPTY);
}

/**
 * The data-slot each component must put on its main element.
 *
 * These follow the shadcn names, so CSS and tests written against shadcn work
 * against April UI too. A component with no shadcn counterpart uses its own
 * name. The registry test checks every component against this map, so a new
 * component has to be added here.
 *
 * @return array<string, string>
 */
function componentSlots(): array
{
    $slots = [];

    foreach (componentNames() as $name) {
        $slots[$name] = $name;
    }

    // Where April UI and shadcn disagree on the name, shadcn wins.
    return array_merge($slots, [
        'breadcrumb-elipsis' => 'breadcrumb-ellipsis',
        'select-option' => 'select-item',
        'sidebar-layout' => 'sidebar-wrapper',
        'sidebar-menu-button-link' => 'sidebar-menu-button',
        'button-link' => 'button',
    ]);
}

/*
|--------------------------------------------------------------------------
| Datasets
|--------------------------------------------------------------------------
*/

dataset('components', fn () => componentNames());
dataset('renderable components', fn () => renderableComponentNames());
