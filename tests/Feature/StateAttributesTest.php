<?php

/*
|--------------------------------------------------------------------------
| State attributes
|--------------------------------------------------------------------------
|
| shadcn reads component state from data attributes rather than from toggled
| classes. April UI writes the starting state into the markup, so the page is
| styled correctly before Alpine boots, and Alpine keeps the attribute current
| after that.
|
| The starting state is checked against the rendered html. The updates are
| checked against the Alpine behaviour, because x-bind applies them in the
| browser and never reaches the server rendered html.
|
*/

/**
 * The source of one Alpine behaviour.
 */
function behaviourSource(string $name): string
{
    return file_get_contents(__DIR__."/../../resources/js/{$name}.js");
}

describe('the starting state in the markup', function () {
    it('marks an overlay closed until it opens', function (string $name) {
        expect(renderComponent($name))->toContain('data-state="closed"');
    })->with([
        'dialog',
        'sheet',
        'popover',
        'dropdown-menu',
        'dropdown-menu-sub',
        'select',
        'banner',
        'accordion-item',
    ]);

    it('marks an alert open, because it shows straight away', function () {
        expect(renderComponent('alert'))->toContain('data-state="open"');
    });

    it('marks a closed date picker', function () {
        expect(renderComponent('date-picker'))->toContain('data-state="closed"');
    });

    it('marks a date picker that starts open', function () {
        expect(renderComponent('date-picker', ':open="true"'))->toContain('data-state="open"');
    });

    it('marks a tooltip that starts open', function () {
        $html = render('<april:tooltip :default-open="true"><x-slot:content>Help</x-slot:content></april:tooltip>');

        expect($html)->toContain('data-state="open"');
    });

    it('marks an unchecked switch', function () {
        expect(renderComponent('switch'))->toContain('data-state="unchecked"');
    });

    it('marks a checked switch', function () {
        expect(renderComponent('switch', 'checked'))->toContain('data-state="checked"');
    });

    it('marks the accordion trigger and content, not only the item', function () {
        $html = render('<april:accordion-item><x-slot:trigger>Q</x-slot:trigger><x-slot:content>A</x-slot:content></april:accordion-item>');

        expect(substr_count($html, 'data-state="closed"'))->toBe(3);
    });

    it('marks the sheet panel, which carries the state classes', function () {
        $html = render('<april:sheet><x-slot:content>Body</x-slot:content></april:sheet>');

        expect(substr_count($html, 'data-state="closed"'))->toBeGreaterThan(1);
    });

    it('gives the sidebar its state from the layout', function () {
        expect(renderComponent('sidebar'))->toContain(':data-state="state"');
    });
});

describe('the state updates that alpine applies', function () {
    it('keeps the state current while the component is open', function (string $behaviour) {
        expect(behaviourSource($behaviour))->toContain("[':data-state']()");
    })->with([
        'dialog',
        'sheet',
        'popover',
        'dropdownMenu',
        'dropdownMenuSub',
        'tooltip',
        'datePicker',
        'banner',
        'alert',
        'select',
        'switchInput',
        'accordionItem',
        'tabsTrigger',
        'tabsContent',
    ]);

    it('uses open and closed for something that opens', function (string $behaviour) {
        expect(behaviourSource($behaviour))->toContain("'open' : 'closed'");
    })->with(['dialog', 'sheet', 'popover', 'dropdownMenu', 'tooltip', 'datePicker', 'select']);

    it('uses checked and unchecked for a switch, as radix does', function () {
        expect(behaviourSource('switchInput'))->toContain("'checked' : 'unchecked'");
    });

    it('uses active and inactive for a tab, as radix does', function (string $behaviour) {
        expect(behaviourSource($behaviour))->toContain("'active' : 'inactive'");
    })->with(['tabsTrigger', 'tabsContent']);

    it('reports a disabled control', function (string $behaviour) {
        expect(behaviourSource($behaviour))->toContain("[':data-disabled']()");
    })->with(['switchInput', 'select', 'accordionItem']);

    it('ships the state bindings in the built bundle', function () {
        expect(file_get_contents(__DIR__.'/../../dist/april.js'))
            ->toContain('":data-state"');
    });
});

describe('what the state attributes unlock', function () {
    it('uses the requested side for sheet transforms', function () {
        $source = file_get_contents(__DIR__.'/../../resources/js/sheet.js');

        expect($source)->toContain("left: '-translate-x-full'");
    });

    it('lets a stylesheet target a part without knowing the markup', function () {
        expect(renderComponent('card'))->toContain('data-slot="card-header"');
    });
});
