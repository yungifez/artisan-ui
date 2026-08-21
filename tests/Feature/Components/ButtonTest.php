<?php

describe('button', function () {
    it('renders a button element', function () {
        expect(renderComponent('button', '', 'Save'))
            ->toContain('<button')
            ->toContain('Save');
    });

    it('uses the primary variant by default', function () {
        expect(classesOf(renderComponent('button')))->toContain('bg-primary');
    });

    it('applies the variant', function (string $variant, string $expected) {
        expect(classesOf(renderComponent('button', "variant=\"{$variant}\"")))
            ->toContain($expected);
    })->with([
        ['destructive', 'bg-destructive'],
        ['outline', 'border-input'],
        ['secondary', 'bg-secondary'],
        ['ghost', 'hover:bg-accent'],
        ['link', 'text-primary'],
    ]);

    it('applies the size', function (string $size, string $expected) {
        expect(classesOf(renderComponent('button', "size=\"{$size}\"")))->toContain($expected);
    })->with([
        ['sm', 'h-9'],
        ['lg', 'h-11'],
        ['icon', 'w-10'],
    ]);

    it('uses the default size when none is given', function () {
        expect(classesOf(renderComponent('button')))->toContain('h-10');
    });

    it('drops the variant classes when the variant is none', function () {
        expect(classesOf(renderComponent('button', 'variant="none"')))
            ->not->toContain('bg-primary')
            ->not->toContain('bg-destructive');
    });

    it('drops the size classes when the size is none', function () {
        expect(classesOf(renderComponent('button', 'size="none"')))
            ->not->toContain('h-10')
            ->not->toContain('px-4');
    });

    it('does not leak the variant attribute into the html', function () {
        expect(renderComponent('button', 'variant="ghost"'))->not->toContain('variant="ghost"');
    });

    it('does not leak the size attribute into the html', function () {
        expect(renderComponent('button', 'size="lg"'))->not->toContain('size="lg"');
    });

    it('keeps the shared classes for every variant', function (string $variant) {
        expect(classesOf(renderComponent('button', "variant=\"{$variant}\"")))
            ->toContain('inline-flex')
            ->toContain('rounded-md');
    })->with(['destructive', 'outline', 'secondary', 'ghost', 'link']);

    it('centers its content by default', function () {
        expect(classesOf(renderComponent('button')))->toContain('justify-center');
    });

    it('allows the content alignment to be overridden', function () {
        expect(classesOf(renderComponent('button', 'class="justify-start"')))
            ->toContain('justify-start')
            ->not->toContain('justify-center');
    });

    it('forwards a type attribute', function () {
        expect(renderComponent('button', 'type="submit"'))->toContain('type="submit"');
    });

    it('forwards a disabled attribute', function () {
        expect(renderComponent('button', 'disabled'))->toContain('disabled');
    });

    it('keeps a class the user passes', function () {
        expect(classesOf(renderComponent('button', 'class="w-full"')))->toContain('w-full');
    });

    it('lets a user class win over the size default', function () {
        expect(classesOf(renderComponent('button', 'class="h-7 w-7" size="icon"')))
            ->toContain('h-7')
            ->toContain('w-7')
            ->not->toContain('h-10')
            ->not->toContain('w-10');
    });

    it('lets a user class win over the variant default', function () {
        expect(classesOf(renderComponent('button', 'class="bg-card"')))
            ->toContain('bg-card')
            ->not->toContain('bg-primary');
    });

    it('does not repeat a class it already has', function () {
        $classes = classesOf(renderComponent('button', 'class="rounded-md"'));

        expect(array_count_values($classes)['rounded-md'])->toBe(1);
    });
});

describe('button link', function () {
    it('renders an anchor element', function () {
        expect(renderComponent('button-link', 'href="/docs"', 'Docs'))
            ->toContain('<a')
            ->toContain('href="/docs"')
            ->toContain('Docs');
    });

    it('applies the variant', function (string $variant, string $expected) {
        expect(classesOf(renderComponent('button-link', "variant=\"{$variant}\"")))
            ->toContain($expected);
    })->with([
        ['destructive', 'bg-destructive'],
        ['outline', 'border-input'],
        ['secondary', 'bg-secondary'],
        ['ghost', 'hover:bg-accent'],
    ]);

    it('removes the underline that a link has by default', function () {
        expect(classesOf(renderComponent('button-link')))->toContain('no-underline');
    });

    it('centers its content by default', function () {
        expect(classesOf(renderComponent('button-link')))->toContain('justify-center');
    });

    it('allows the content alignment to be overridden', function () {
        expect(classesOf(renderComponent('button-link', 'class="justify-start"')))
            ->toContain('justify-start')
            ->not->toContain('justify-center');
    });

    it('does not leak the variant or size attributes', function () {
        expect(renderComponent('button-link', 'variant="ghost" size="lg"'))
            ->not->toContain('variant=')
            ->not->toContain('size=');
    });

    it('lets a user class win over the size default', function () {
        expect(classesOf(renderComponent('button-link', 'class="h-7"')))
            ->toContain('h-7')
            ->not->toContain('h-10');
    });
});
