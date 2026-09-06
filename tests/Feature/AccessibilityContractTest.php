<?php

describe('component accessibility contracts', function () {
    it('does not turn ordinary component buttons into form submits', function (string $component) {
        $html = renderComponent($component);

        preg_match_all('/<button\b([^>]*)>/i', $html, $matches);

        foreach ($matches[1] as $attributes) {
            expect($attributes)->toMatch('/\btype=["\']button["\']/i', $component.' has a button without type="button".');
        }
    })->with(['button', 'calendar', 'combobox', 'select', 'switch', 'tabs-trigger']);

    it('places a component title one level under the page heading', function (string $markup) {
        // A page heading is an h1. A title that starts lower skips a level, so
        // a reader moving by heading cannot tell whether a section is missing.
        expect(render($markup))->toContain('<h2');
    })->with([
        '<april:card><x-slot:title>Billing</x-slot:title></april:card>',
        '<april:alert><x-slot:title>Heads up</x-slot:title></april:alert>',
        '<april:dialog-header><x-slot:title>Confirm</x-slot:title></april:dialog-header>',
        '<april:sheet-header><x-slot:title>Menu</x-slot:title></april:sheet-header>',
    ]);

    it('keeps semantic roles and labels on composite controls', function () {
        expect(render('<april:switch aria-label="Enable alerts" />'))
            ->toContain('role="switch"')
            ->toContain('aria-label="Enable alerts"');

        expect(render('<april:calendar />'))
            ->toContain('role="grid"')
            ->toContain('aria-label="Calendar"');

        expect(render('<april:dialog><slot:content>Dialog body</slot:content></april:dialog>'))
            ->toContain('role="dialog"');
    });
});
