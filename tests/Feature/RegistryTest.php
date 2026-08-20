<?php

use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Registry
|--------------------------------------------------------------------------
|
| These tests validate the component set as a whole. They run over every file
| in resources/views/components, so a new component is checked as soon as you
| add it. No list needs updating.
|
*/

describe('component views', function () {
    it('ships a component set', function () {
        expect(componentNames())->not->toBeEmpty();
    });

    it('resolves in the april view namespace', function (string $name) {
        expect(View::exists("april::components.{$name}"))->toBeTrue();
    })->with('components');

    it('uses a lower case kebab name', function (string $name) {
        expect($name)->toMatch('/^[a-z0-9]+(-[a-z0-9]+)*$/');
    })->with('components');

    it('has a unique name', function () {
        expect(array_unique(componentNames()))->toHaveCount(count(componentNames()));
    });

    it('has content', function (string $name) {
        expect(filesize(componentPath($name)))->toBeGreaterThan(0);
    })->with('renderable components');

    it('has no empty component outside the known list', function () {
        $empty = array_values(array_filter(
            componentNames(),
            fn (string $name): bool => filesize(componentPath($name)) === 0
        ));

        expect($empty)->toBe(
            emptyComponents(),
            'Update emptyComponents() in tests/Pest.php to match the components that are still empty.'
        );
    });

    it('renders without error', function (string $name) {
        expect(renderComponent($name, '', 'content'))->toBeString();
    })->with('renderable components');

    it('renders at least one html element', function (string $name) {
        expect(trim(renderComponent($name, '', 'content')))->toStartWith('<');
    })->with('renderable components');

    it('does not leak an unresolved blade directive', function (string $name) {
        expect(renderComponent($name, '', 'content'))
            ->not->toContain('@endComponentClass')
            ->not->toContain('##END-COMPONENT-CLASS##')
            ->not->toContain('<?php');
    })->with('renderable components');
});

describe('data slots', function () {
    /*
     * shadcn marks every part of a component with a data-slot. Keeping the same
     * names means a stylesheet or a test written against shadcn also works here.
     */

    it('marks its main element with a data-slot', function (string $name) {
        expect(renderComponent($name, '', 'content'))
            ->toContain('data-slot="'.componentSlots()[$name].'"');
    })->with('renderable components');

    it('has a slot name for every component', function () {
        expect(array_keys(componentSlots()))->toBe(componentNames());
    });

    it('never writes the same data-slot twice on one element', function (string $name) {
        $html = renderComponent($name, '', 'content');

        foreach (explode('<', $html) as $tag) {
            $tag = explode('>', $tag)[0];

            expect(substr_count($tag, 'data-slot='))
                ->toBeLessThan(2, "{$name} puts two data-slot attributes on one element.");
        }
    })->with('renderable components');

    it('lets a wrapper override the slot of the component it builds on', function () {
        expect(renderComponent('sidebar-input'))
            ->toContain('data-slot="sidebar-input"')
            ->not->toContain('data-slot="input"');
    });
});

describe('view source', function () {
    /**
     * The component names a view refers to with an april tag.
     *
     * @return list<string>
     */
    function referencedComponents(string $file): array
    {
        preg_match_all('/<\/?april:([a-z0-9-]+)/', file_get_contents($file), $matches);

        return array_values(array_unique($matches[1]));
    }

    it('only refers to components that exist', function (string $name) {
        expect(array_diff(referencedComponents(componentPath($name)), componentNames()))
            ->toBeEmpty("{$name} refers to a component that does not exist.");
    })->with('renderable components');

    it('closes an april tag with a single colon', function (string $name) {
        expect(str_contains(file_get_contents(componentPath($name)), '</april::'))
            ->toBeFalse("{$name} closes a tag with a double colon.");
    })->with('renderable components');

    it('does not refer to itself', function (string $name) {
        expect(in_array($name, referencedComponents(componentPath($name)), true))
            ->toBeFalse("{$name} renders itself, which never ends.");
    })->with('renderable components');
});

describe('alpine behaviours', function () {
    /**
     * The names passed to Alpine.data in the javascript entry point.
     *
     * @return list<string>
     */
    function registeredAlpineComponents(): array
    {
        $source = file_get_contents(__DIR__.'/../../resources/js/components.js');

        preg_match_all("/^import\s+([a-zA-Z][a-zA-Z0-9_]*)\s+from\s+'\.\/[^']+\.js';/m", $source, $matches);

        $names = array_unique($matches[1]);
        sort($names);

        return array_values($names);
    }

    /**
     * The names used in an x-data attribute across all component views.
     *
     * @return list<string>
     */
    function usedAlpineComponents(): array
    {
        $names = [];

        foreach (glob(componentPath().'/*.blade.php') as $file) {
            // Matches x-data="name(...)" and the shorthand x-data="name".
            preg_match_all('/x-data=[\'"]([a-zA-Z][a-zA-Z0-9_]*)\s*[("\']/', file_get_contents($file), $matches);

            $names = array_merge($names, $matches[1]);
        }

        $names = array_unique($names);
        sort($names);

        return array_values($names);
    }

    it('registers every behaviour a view uses', function () {
        expect(array_diff(usedAlpineComponents(), registeredAlpineComponents()))
            ->toBeEmpty('A view uses an Alpine behaviour that april.js does not register.');
    });

    it('does not register a behaviour no view uses', function () {
        expect(array_diff(registeredAlpineComponents(), usedAlpineComponents()))
            ->toBeEmpty('april.js registers an Alpine behaviour that no view uses.');
    });

    it('has a source file for every registered behaviour', function () {
        foreach (registeredAlpineComponents() as $name) {
            expect(__DIR__."/../../resources/js/{$name}.js")->toBeFile();
        }
    });

    it('imports every source file in the entry point', function () {
        $source = file_get_contents(__DIR__.'/../../resources/js/components.js');

        foreach (registeredAlpineComponents() as $name) {
            expect($source)->toContain("import {$name} from './{$name}.js'");
        }
    });
});

describe('built assets', function () {
    it('ships every file the routes serve', function (string $file) {
        expect(__DIR__."/../../dist/{$file}")->toBeFile();
    })->with(['april.js', 'april.min.js', 'april.css', 'april.min.css', 'manifest.json']);

    it('ships a manifest with a hash for each entry point', function () {
        $manifest = json_decode(file_get_contents(__DIR__.'/../../dist/manifest.json'), true);

        expect($manifest)
            ->toBeArray()
            ->toHaveKeys(['/april.js', '/april.css'])
            ->and($manifest['/april.js'])->toBeString()->not->toBeEmpty()
            ->and($manifest['/april.css'])->toBeString()->not->toBeEmpty();
    });

    it('builds a smaller minified bundle than the readable one', function (string $name) {
        expect(filesize(__DIR__."/../../dist/{$name}.min.js"))
            ->toBeLessThan(filesize(__DIR__."/../../dist/{$name}.js"));
    })->with(['april']);
});
