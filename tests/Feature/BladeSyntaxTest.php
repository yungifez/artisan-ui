<?php

use Yungifez\AprilUI\AprilBladeCompiler;
use Yungifez\AprilUI\AprilComponentTagCompiler;

/*
|--------------------------------------------------------------------------
| Blade syntax
|--------------------------------------------------------------------------
|
| April UI adds an <april:name> tag on top of the Blade component syntax. These
| tests cover the compiler that makes it work.
|
*/

describe('the compiler', function () {
    it('is resolvable from the container', function () {
        expect(app(AprilBladeCompiler::class))->toBeInstanceOf(AprilBladeCompiler::class);
    });

    it('uses the april tag compiler', function () {
        expect(app(AprilComponentTagCompiler::class))->toBeInstanceOf(AprilComponentTagCompiler::class);
    });

    it('maps an april tag to the april view namespace', function () {
        $compiled = app(AprilBladeCompiler::class)->compile('<april:badge />');

        expect($compiled)->toContain('april::badge');
    });

    it('leaves plain html untouched', function () {
        $html = '<div class="p-2"><a href="/x">link</a><span>text</span></div>';

        expect(app(AprilBladeCompiler::class)->compile($html))->toBe($html);
    });

    it('leaves an alpine attribute untouched', function () {
        $html = '<div x-data="dropdownMenu" x-bind="root"></div>';

        expect(app(AprilBladeCompiler::class)->compile($html))->toBe($html);
    });

    it('leaves a comparison operator untouched', function () {
        $html = '@if ($a < $b) yes @endif';

        expect(app(AprilBladeCompiler::class)->compile($html))->toBe($html);
    });
});

describe('tag syntax', function () {
    it('renders a self closing april tag', function () {
        expect(render('<april:badge />'))->toContain('<div');
    });

    it('renders a paired april tag', function () {
        expect(render('<april:label>Email</april:label>'))->toContain('Email');
    });

    it('still supports the x-april namespace', function () {
        expect(render('<x-april::label>Email</x-april::label>'))->toContain('Email');
    });

    it('renders both syntaxes the same way', function () {
        expect(render('<april:label>Email</april:label>'))
            ->toBe(render('<x-april::label>Email</x-april::label>'));
    });

    it('renders a tag that spans several lines', function () {
        $html = render("<april:label\n    class=\"mt-2\"\n    for=\"email\"\n>Email</april:label>");

        expect($html)->toContain('for="email"')->toContain('Email');
    });
});

describe('attributes', function () {
    it('forwards a plain attribute', function () {
        expect(renderComponent('label', 'for="email"'))->toContain('for="email"');
    });

    it('forwards a bound attribute', function () {
        $html = render('<april:label :for="$field">Email</april:label>', ['field' => 'email']);

        expect($html)->toContain('for="email"');
    });

    it('forwards a data attribute', function () {
        expect(renderComponent('skeleton', 'data-testid="loading"'))
            ->toContain('data-testid="loading"');
    });

    it('forwards an alpine attribute', function () {
        expect(renderComponent('skeleton', 'x-show="open"'))->toContain('x-show="open"');
    });

    it('forwards an event attribute', function () {
        expect(renderComponent('button', 'type="submit"'))->toContain('type="submit"');
    });

    it('renders april tags with conditional attributes', function () {
        $template = <<<'BLADE'
<april:input
    @if ($withPlaceholder) placeholder="you@example.com" @endif
    @if ($withAutocomplete) autocomplete="email" @endif
    data-testid="email"
/>
BLADE;

        $html = render($template, [
            'withPlaceholder' => true,
            'withAutocomplete' => false,
        ]);

        expect($html)
            ->toContain('<input')
            ->toContain('placeholder="you@example.com"')
            ->toContain('data-testid="email"')
            ->not->toContain('autocomplete="email"')
            ->not->toContain('@if');
    });

    it('escapes an attribute value', function () {
        expect(renderComponent('label', 'title="a &quot; b"'))->not->toContain('title="a " b"');
    });
});

describe('slots', function () {
    it('renders the default slot', function () {
        expect(renderComponent('label', '', 'Email address'))->toContain('Email address');
    });

    it('renders a named slot with the x-slot syntax', function () {
        $html = render('<april:card><x-slot:title>Billing</x-slot:title></april:card>');

        expect($html)->toContain('Billing');
    });

    it('renders a named slot with the bare slot syntax', function () {
        $html = render('<april:card><slot:title>Billing</slot:title></april:card>');

        expect($html)->toContain('Billing');
    });

    it('applies attributes given on a named slot', function () {
        $html = render('<april:card><x-slot:title class="text-red-500">Billing</x-slot:title></april:card>');

        expect($html)->toContain('text-red-500');
    });

    it('renders one april component inside another', function () {
        $html = render('<april:label><april:badge>New</april:badge></april:label>');

        expect($html)->toContain('New')
            ->and(substr_count($html, '<div'))->toBeGreaterThan(0);
    });

    it('renders a component inside a blade loop', function () {
        $html = render('@foreach ([1, 2, 3] as $i)<april:badge>{{ $i }}</april:badge>@endforeach');

        expect(substr_count($html, '<div'))->toBe(3);
    });
});

it('fails on an unknown component', function () {
    render('<april:not-a-real-component />');
})->throws(InvalidArgumentException::class);
