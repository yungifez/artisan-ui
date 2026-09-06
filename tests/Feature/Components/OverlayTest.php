<?php

describe('dialog', function () {
    it('is driven by the dialog behaviour', function () {
        expect(renderComponent('dialog'))->toContain('x-data="dialog(false,');
    });

    it('has the dialog role', function () {
        $html = render('<april:dialog><x-slot:content>Body</x-slot:content></april:dialog>');

        expect($html)->toContain('role="dialog"');
    });

    it('covers the page with an overlay', function () {
        expect(renderComponent('dialog'))
            ->toContain('x-bind="overlay"')
            ->toContain('bg-black/80');
    });

    it('renders the trigger slot', function () {
        $html = render('<april:dialog><x-slot:trigger>Open</x-slot:trigger></april:dialog>');

        expect($html)->toContain('Open')->toContain('x-bind="trigger"');
    });

    it('renders the content slot', function () {
        $html = render('<april:dialog><x-slot:content>Body</x-slot:content></april:dialog>');

        expect($html)->toContain('Body')->toContain('x-bind="dialog"');
    });

    it('tells the behaviour when it is dismissable', function () {
        expect(renderComponent('dialog', 'dismissable'))->toContain('dialog(false, true)');
    });

    it('teleports the overlay on request', function () {
        expect(renderComponent('dialog', 'x-teleport="body"'))
            ->toContain('<template x-teleport="body">');
    });

    it('does not teleport by default', function () {
        expect(renderComponent('dialog'))->not->toContain('x-teleport');
    });

    it('keeps the teleport target out of the overlay attributes', function () {
        expect(classesOf(renderComponent('dialog', 'x-teleport="body"')))->not->toBeEmpty();
    });

    it('hides the overlay until alpine starts', function () {
        expect(renderComponent('dialog'))->toContain('x-cloak');
    });

    it('keeps dismissable as a behaviour prop instead of forwarding it', function () {
        $html = renderComponent('dialog', 'id="dialog-root" dismissable');

        expect($html)->toContain('id="dialog-root"')
            ->not->toContain('dismissable="dismissable"');
    });
});

describe('alert dialog', function () {
    it('is driven by the alert dialog behaviour', function () {
        expect(renderComponent('alert-dialog'))->toContain('x-data="alertDialog(false,');
    });

    it('has the alert dialog role', function () {
        $html = render('<april:alert-dialog><x-slot:content>Body</x-slot:content></april:alert-dialog>');

        expect($html)->toContain('role="alertdialog"');
    });

    it('hides the overlay until alpine starts', function () {
        expect(renderComponent('alert-dialog'))->toContain('x-cloak');
    });
});

describe('dialog header and footer', function () {
    it('renders the header title slot', function () {
        $html = render('<april:dialog-header><x-slot:title>Confirm</x-slot:title></april:dialog-header>');

        expect($html)->toContain('<h2')->toContain('Confirm');
    });

    it('lets the page place the header title in its heading order', function () {
        $html = render('<april:dialog-header level="3"><x-slot:title>Confirm</x-slot:title></april:dialog-header>');

        expect($html)->toContain('<h3')->not->toContain('<h2');
    });

    it('renders the header description slot', function () {
        $html = render('<april:dialog-header><x-slot:description>Are you sure</x-slot:description></april:dialog-header>');

        expect($html)->toContain('<p')->toContain('Are you sure');
    });

    it('renders the footer slot', function () {
        expect(renderComponent('dialog-footer', '', 'Actions'))->toContain('Actions');
    });

    it('offers a default close button in the footer', function () {
        expect(renderComponent('dialog-footer'))->toContain('Close');
    });

    it('stacks the footer actions on a small screen', function () {
        expect(classesOf(renderComponent('dialog-footer')))->toContain('flex-col-reverse');
    });
});

describe('sheet', function () {
    it('is driven by the dialog behaviour', function () {
        expect(renderComponent('sheet'))->toContain('x-data="dialog(false,');
    });

    it('passes the side to the sheet behaviour', function () {
        $html = render('<april:sheet><x-slot:content side="left">Body</x-slot:content></april:sheet>');

        expect($html)->toContain("x-data=\"sheet('left'");
    });

    it('renders the trigger slot', function () {
        $html = render('<april:sheet><x-slot:trigger>Open</x-slot:trigger></april:sheet>');

        expect($html)->toContain('Open');
    });

    it('renders the header title slot', function () {
        $html = render('<april:sheet-header><x-slot:title>Menu</x-slot:title></april:sheet-header>');

        expect($html)->toContain('<h2')->toContain('Menu');
    });

    it('lets the page place the header title in its heading order', function () {
        $html = render('<april:sheet-header level="3"><x-slot:title>Menu</x-slot:title></april:sheet-header>');

        expect($html)->toContain('<h3')->not->toContain('<h2');
    });

    it('renders the footer slot', function () {
        expect(renderComponent('sheet-footer', '', 'Save'))->toContain('Save');
    });
});

describe('popover', function () {
    it('is driven by the popover behaviour', function () {
        expect(renderComponent('popover'))->toContain('x-data="popover"');
    });

    it('offers a default trigger button', function () {
        expect(renderComponent('popover'))->toContain('Open');
    });

    it('renders a custom trigger slot', function () {
        $html = render('<april:popover><x-slot:popoverTrigger>Pick a date</x-slot:popoverTrigger></april:popover>');

        expect($html)->toContain('Pick a date');
    });

    it('accepts the canonical trigger slot name', function () {
        $html = render('<april:popover><x-slot:trigger>Canonical trigger</x-slot:trigger></april:popover>');

        expect($html)->toContain('Canonical trigger');
    });

    it('renders the content slot', function () {
        $html = render('<april:popover><x-slot:popoverContent>Body</x-slot:popoverContent></april:popover>');

        expect($html)->toContain('Body')->toContain('bg-popover');
    });

    it('accepts the canonical content slot name', function () {
        $html = render('<april:popover><x-slot:content>Canonical body</x-slot:content></april:popover>');

        expect($html)->toContain('Canonical body')->toContain('bg-popover');
    });

    it('hides the content until alpine starts', function () {
        $html = render('<april:popover><x-slot:popoverContent>Body</x-slot:popoverContent></april:popover>');

        expect($html)->toContain('x-cloak');
    });

    it('teleports the content on request', function () {
        $html = render('<april:popover x-teleport="body"><x-slot:popoverContent>Body</x-slot:popoverContent></april:popover>');

        expect($html)->toContain('<template x-teleport="body">');
    });
});

describe('dropdown menu', function () {
    it('is driven by the dropdown behaviour', function () {
        expect(renderComponent('dropdown-menu'))->toContain('x-data="dropdownMenu"');
    });

    it('renders the trigger slot', function () {
        $html = render('<april:dropdown-menu><x-slot:trigger>Open</x-slot:trigger></april:dropdown-menu>');

        expect($html)->toContain('Open')->toContain('aria-haspopup="menu"');
    });

    it('renders the content slot as a menu', function () {
        $html = render('<april:dropdown-menu><x-slot:content>Items</x-slot:content></april:dropdown-menu>');

        expect($html)->toContain('role="menu"')->toContain('Items');
    });

    it('teleports the content on request', function () {
        $html = render('<april:dropdown-menu x-teleport="body"><x-slot:content>Items</x-slot:content></april:dropdown-menu>');

        expect($html)->toContain('<template x-teleport="body">');
    });

    it('renders a menu item as a ghost button', function () {
        $html = renderComponent('dropdown-menu-item', '', 'Profile');

        expect($html)
            ->toContain('Profile')
            ->toContain('role="menuitem"')
            ->toContain('justify-start')
            ->not->toContain('justify-center');
    });

    it('renders a menu label', function () {
        expect(renderComponent('dropdown-menu-label', '', 'Account'))->toContain('Account');
    });

    it('does not put a menu label in the page heading order', function () {
        // A label inside role="menu" names a group of items. As a heading it
        // landed four levels under the page heading and skipped every one.
        expect(renderComponent('dropdown-menu-label', '', 'Account'))
            ->toContain('<div data-slot="dropdown-menu-label"')
            ->not->toContain('<h6');
    });

    it('renders a menu separator', function () {
        expect(renderComponent('dropdown-menu-separator'))->toContain('<div');
    });

    it('renders a keyboard shortcut', function () {
        expect(renderComponent('dropdown-menu-shortcut', '', 'Ctrl+K'))->toContain('Ctrl+K');
    });

    it('renders a submenu', function () {
        expect(renderComponent('dropdown-menu-sub'))->toContain('x-data="dropdownMenuSub"');
    });
});

describe('tooltip', function () {
    it('is driven by the tooltip behaviour', function () {
        expect(renderComponent('tooltip'))->toContain('x-data="tooltip(');
    });

    it('uses the default delays', function () {
        expect(renderComponent('tooltip'))->toContain('tooltip(50, 100,');
    });

    it('takes custom delays', function () {
        expect(renderComponent('tooltip', ':delay-duration="300" :skip-delay-duration="600"'))
            ->toContain('tooltip(300, 600,');
    });

    it('renders the trigger slot', function () {
        $html = render('<april:tooltip><x-slot:trigger>Hover me</x-slot:trigger></april:tooltip>');

        expect($html)->toContain('Hover me')->toContain('x-ref="trigger"');
    });

    it('renders the content slot', function () {
        $html = render('<april:tooltip><x-slot:content>Help text</x-slot:content></april:tooltip>');

        expect($html)->toContain('Help text')->toContain('bg-primary');
    });

    it('draws a default arrow', function () {
        $html = render('<april:tooltip><x-slot:content>Help text</x-slot:content></april:tooltip>');

        expect($html)->toContain('<svg')->toContain('<polygon');
    });

    it('takes a custom arrow', function () {
        $html = render('<april:tooltip><x-slot:content>Help</x-slot:content><x-slot:svg>arrow</x-slot:svg></april:tooltip>');

        expect($html)->toContain('arrow')->not->toContain('<polygon');
    });
});
