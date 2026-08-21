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
});

describe('dialog header and footer', function () {
    it('renders the header title slot', function () {
        $html = render('<april:dialog-header><x-slot:title>Confirm</x-slot:title></april:dialog-header>');

        expect($html)->toContain('<h4')->toContain('Confirm');
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

    it('uses a right-side transform by default', function () {
        $source = file_get_contents(__DIR__.'/../../../resources/js/sheet.js');

        expect($source)->toContain("right: 'translate-x-full'");
    });

    it('slides in from the requested side', function (string $side, string $expected) {
        $html = render("<april:sheet><x-slot:content side=\"{$side}\">Body</x-slot:content></april:sheet>");

        expect(file_get_contents(__DIR__.'/../../../resources/js/sheet.js'))->toContain($expected);
    })->with([
        ['top', "top: '-translate-y-full'"],
        ['bottom', "bottom: 'translate-y-full'"],
        ['left', "left: '-translate-x-full'"],
        ['right', "right: 'translate-x-full'"],
    ]);

    it('passes the side to the sheet behaviour', function () {
        $html = render('<april:sheet><x-slot:content side="left">Body</x-slot:content></april:sheet>');

        expect($html)->toContain("x-data=\"sheet('left'");
    });

    it('uses transform transitions for panel movement', function () {
        $source = file_get_contents(__DIR__.'/../../../resources/js/sheet.js');

        expect($source)
            ->toContain('transition-transform ease-in-out duration-500')
            ->toContain('transition-transform ease-in-out duration-300')
            ->not->toContain('transition-opacity');
    });

    it('keeps the overlay mounted for the shadcn close animation', function () {
        $source = file_get_contents(__DIR__.'/../../../resources/js/dialog.js');

        expect($source)->toContain('x-transition.opacity.duration.300ms');
    });

    it('renders the trigger slot', function () {
        $html = render('<april:sheet><x-slot:trigger>Open</x-slot:trigger></april:sheet>');

        expect($html)->toContain('Open');
    });

    it('renders the header title slot', function () {
        $html = render('<april:sheet-header><x-slot:title>Menu</x-slot:title></april:sheet-header>');

        expect($html)->toContain('<h4')->toContain('Menu');
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

    it('renders the content slot', function () {
        $html = render('<april:popover><x-slot:popoverContent>Body</x-slot:popoverContent></april:popover>');

        expect($html)->toContain('Body')->toContain('bg-popover');
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

        expect($html)->toContain('Profile')->toContain('role="menuitem"');
    });

    it('renders a menu label', function () {
        expect(renderComponent('dropdown-menu-label', '', 'Account'))->toContain('Account');
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
