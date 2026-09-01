<?php

describe('component accessibility contracts', function () {
    it('does not turn ordinary component buttons into form submits', function (string $component) {
        $html = renderComponent($component);

        preg_match_all('/<button\b([^>]*)>/i', $html, $matches);

        foreach ($matches[1] as $attributes) {
            expect($attributes)->toMatch('/\btype=["\']button["\']/i', $component.' has a button without type="button".');
        }
    })->with(['button', 'calendar', 'combobox', 'select', 'switch', 'tabs-trigger']);

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
