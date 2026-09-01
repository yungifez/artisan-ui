<?php

describe('badge', function () {
    it('renders its slot', function () {
        expect(renderComponent('badge', '', 'New'))->toContain('New');
    });

    it('is a pill by default', function () {
        expect(classesOf(renderComponent('badge')))
            ->toContain('rounded-full')
            ->toContain('inline-flex');
    });

    it('applies the variant', function (string $variant, string $expected) {
        expect(classesOf(renderComponent('badge', "variant=\"{$variant}\"")))->toContain($expected);
    })->with([
        ['destructive', 'bg-destructive'],
        ['secondary', 'bg-secondary'],
        ['outline', 'text-foreground'],
    ]);

    it('uses the primary variant by default', function () {
        expect(classesOf(renderComponent('badge')))->toContain('bg-primary');
    });

    it('does not leak its variant prop into rendered markup', function () {
        expect(renderComponent('badge', 'variant="secondary"'))
            ->not->toContain('variant="secondary"');
    });

    it('drops the variant classes when the variant is none', function () {
        expect(classesOf(renderComponent('badge', 'variant="none"')))
            ->not->toContain('bg-primary');
    });

    it('lets a user class win over the default', function () {
        expect(classesOf(renderComponent('badge', 'class="rounded-none"')))
            ->toContain('rounded-none')
            ->not->toContain('rounded-full');
    });
});

describe('alert', function () {
    it('has the alert role', function () {
        expect(renderComponent('alert'))->toContain('role="alert"');
    });

    it('is driven by the alpine behaviour', function () {
        expect(renderComponent('alert'))->toContain('x-data=\'alert(');
    });

    it('renders the title slot in a heading', function () {
        $html = render('<april:alert><x-slot:title>Heads up</x-slot:title></april:alert>');

        expect($html)->toContain('<h5')->toContain('Heads up');
    });

    it('renders the description slot', function () {
        $html = render('<april:alert><x-slot:description>Read this</x-slot:description></april:alert>');

        expect($html)->toContain('Read this');
    });

    it('renders the icon slot', function () {
        $html = render('<april:alert><x-slot:icon>!</x-slot:icon></april:alert>');

        expect($html)->toContain('flex items-start');
    });

    it('applies the destructive variant', function () {
        expect(renderComponent('alert', 'variant="destructive"'))->toContain('text-destructive');
    });

    it('hides the close button by default', function () {
        expect(renderComponent('alert'))->not->toContain('Close');
    });

    it('shows a close button when the alert is dismissable', function () {
        expect(renderComponent('alert', ':dismissable="true"'))
            ->toContain('Close')
            ->toContain('x-bind="dismissTrigger"');
    });

    it('passes the timeout to the behaviour', function () {
        expect(renderComponent('alert', 'timeout="2500"'))->toContain('2500');
    });
});

describe('chart', function () {
    it('uses the Alpine chart behaviour when data is supplied', function () {
        $html = render('<april:chart :data="$data" :config="$config" xKey="month" />', [
            'data' => [['month' => 'Jan', 'desktop' => 186]],
            'config' => ['desktop' => ['label' => 'Desktop', 'color' => 'var(--chart-1)']],
        ]);

        expect($html)
            ->toContain("x-data='chart(")
            ->toContain('data-slot="chart-tooltip"')
            ->toContain('data-slot="chart-legend"')
            ->toContain('var(--chart-1)');
    });

    it('keeps chart bars as a static fallback without data', function () {
        $html = render('<april:chart><april:chart-bar label="Jan" value="48" /></april:chart>');

        expect($html)->toContain('data-slot="chart-bar"')->toContain('height: 48%');
    });
});

describe('data table', function () {
    it('keeps the semantic slot composition available without columns', function () {
        $html = render('<april:data-table><x-slot:header>Header</x-slot:header><x-slot:body>Rows</x-slot:body></april:data-table>');

        expect($html)->toContain('data-slot="data-table-header"')->toContain('Header')->toContain('Rows');
    });

    it('renders the interactive Alpine table when columns are supplied', function () {
        $html = render('<april:data-table :data="$data" :columns="$columns" searchable selectable paginated />', [
            'data' => [['id' => 1, 'name' => 'Olivia Martin']],
            'columns' => [['key' => 'name', 'label' => 'Name', 'sortable' => true]],
        ]);

        expect($html)
            ->toContain('x-data="dataTable(')
            ->toContain('data-slot="data-table-toolbar"')
            ->toContain('toggleSort')
            ->toContain('toggleVisibleRows')
            ->toContain('data-slot="data-table-pagination"');
    });

    it('renders named cell and action slots inside dynamic rows', function () {
        $html = render('<april:data-table :data="$data" :columns="$columns"><x-slot:cell-status><span x-text="row.status"></span></x-slot:cell-status><x-slot:actions><button x-text="row.name"></button></x-slot:actions></april:data-table>', [
            'data' => [['id' => 1, 'status' => 'Active', 'name' => 'Olivia Martin']],
            'columns' => [['key' => 'status', 'label' => 'Status']],
        ]);

        expect($html)->toContain('x-text="row.status"')->toContain('x-text="row.name"');
    });

    it('accepts controlled pagination metadata without a framework dependency', function () {
        $html = render('<april:data-table :data="$data" :columns="$columns" :pagination="$pagination" />', [
            'data' => [['id' => 3, 'name' => 'Isabella Nguyen']],
            'columns' => [['key' => 'name', 'label' => 'Name', 'sortable' => true]],
            'pagination' => ['mode' => 'controlled', 'page' => 2, 'perPage' => 2, 'total' => 3],
        ]);

        expect($html)
            ->toContain('\\u0022mode\\u0022:\\u0022controlled\\u0022')
            ->toContain('x-bind="root"')
            ->toContain('data-slot="data-table-pagination"');
    });
});

describe('steps', function () {
    it('renders shadcn-style progress states', function () {
        $html = render('<april:steps :items="$items" current="2" />', [
            'items' => [
                ['value' => 1, 'label' => 'Account'],
                ['value' => 2, 'label' => 'Profile', 'description' => 'Add your details'],
                ['value' => 3, 'label' => 'Review'],
            ],
        ]);

        expect($html)
            ->toContain('data-slot="steps"')
            ->toContain('data-slot="step-indicator"')
            ->toContain('data-slot="step-separator"')
            ->toContain('data-state="completed"')
            ->toContain('data-state="active"')
            ->toContain('data-state="inactive"')
            ->toContain('aria-current="step"')
            ->toContain('Add your details');
    });

    it('supports vertical orientation and completed links', function () {
        $html = render('<april:steps orientation="vertical" :items="$items" current="3" />', [
            'items' => [
                ['value' => 1, 'label' => 'Account', 'href' => '/account'],
                ['value' => 2, 'label' => 'Profile', 'href' => '/profile'],
                ['value' => 3, 'label' => 'Review'],
            ],
        ]);

        expect($html)
            ->toContain('data-orientation="vertical"')
            ->toContain('href="/account"')
            ->toContain('href="/profile"')
            ->toContain('data-slot="step-title"');
    });
});

describe('card', function () {
    it('renders a bordered surface', function () {
        expect(classesOf(renderComponent('card')))
            ->toContain('rounded-lg')
            ->toContain('border')
            ->toContain('bg-card');
    });

    it('renders the title slot in a heading', function () {
        $html = render('<april:card><x-slot:title>Billing</x-slot:title></april:card>');

        expect($html)->toContain('<h3')->toContain('Billing');
    });

    it('renders the description slot in a paragraph', function () {
        $html = render('<april:card><x-slot:description>Your plan</x-slot:description></april:card>');

        expect($html)->toContain('<p')->toContain('Your plan');
    });

    it('renders the content slot', function () {
        $html = render('<april:card><x-slot:content>Body text</x-slot:content></april:card>');

        expect($html)->toContain('Body text');
    });

    it('renders the footer slot', function () {
        $html = render('<april:card><x-slot:footer>Actions</x-slot:footer></april:card>');

        expect($html)->toContain('Actions');
    });

    it('lets a slot carry its own classes', function () {
        $html = render('<april:card><x-slot:title class="text-red-500">Billing</x-slot:title></april:card>');

        expect($html)->toContain('text-red-500');
    });
});

describe('avatar', function () {
    it('is a circle by default', function () {
        expect(classesOf(renderComponent('avatar')))->toContain('rounded-full');
    });

    it('takes a custom border radius', function () {
        expect(classesOf(renderComponent('avatar', 'border-radius="rounded-md"')))
            ->toContain('rounded-md')
            ->not->toContain('rounded-full');
    });

    it('applies the size', function (string $size, string $expected) {
        expect(classesOf(renderComponent('avatar', "size=\"{$size}\"")))->toContain($expected);
    })->with([
        ['sm', 'h-8'],
        ['lg', 'h-16'],
    ]);

    it('uses the default size when none is given', function () {
        expect(classesOf(renderComponent('avatar')))->toContain('h-10');
    });

    it('renders the image slot', function () {
        $html = render('<april:avatar><x-slot:image src="/me.png"></x-slot:image></april:avatar>');

        expect($html)->toContain('<img')->toContain('src="/me.png"');
    });

    it('renders the fallback slot', function () {
        $html = render('<april:avatar><x-slot:fallback>MI</x-slot:fallback></april:avatar>');

        expect($html)->toContain('MI')->toContain('x-bind="fallback"');
    });
});

describe('skeleton', function () {
    it('pulses while loading', function () {
        expect(classesOf(renderComponent('skeleton')))->toContain('animate-pulse');
    });

    it('renders its slot', function () {
        expect(renderComponent('skeleton', '', 'loading'))->toContain('loading');
    });
});

describe('separator', function () {
    it('is horizontal by default', function () {
        expect(renderComponent('separator'))->toContain('data-orientation="horizontal"');
    });

    it('records a vertical orientation', function () {
        expect(renderComponent('separator', 'orientation="vertical"'))
            ->toContain('data-orientation="vertical"');
    });

    it('is hidden from the accessibility tree', function () {
        expect(renderComponent('separator'))->toContain('role="none"');
    });

    it('uses the border colour', function () {
        expect(classesOf(renderComponent('separator')))->toContain('bg-border');
    });

    it('draws a horizontal rule across the width', function () {
        expect(classesOf(renderComponent('separator')))
            ->toContain('h-[1px]')
            ->toContain('w-full');
    });

    it('draws a vertical rule down the height', function () {
        expect(classesOf(renderComponent('separator', 'orientation="vertical"')))
            ->toContain('w-[1px]')
            ->toContain('h-full');
    });

    it('does not draw a vertical rule the same way as a horizontal one', function () {
        expect(classesOf(renderComponent('separator', 'orientation="vertical"')))
            ->not->toBe(classesOf(renderComponent('separator')));
    });
});

describe('breadcrumb', function () {
    it('renders a labelled nav element', function () {
        expect(renderComponent('breadcrumb'))
            ->toContain('<nav')
            ->toContain('aria-label="breadcrumb"');
    });

    it('renders the list slot in an ordered list', function () {
        $html = render('<april:breadcrumb><x-slot:list>items</x-slot:list></april:breadcrumb>');

        expect($html)->toContain('<ol')->toContain('items');
    });

    it('keeps list attributes on the list instead of duplicating them on the nav', function () {
        $html = render('<april:breadcrumb><x-slot:list id="breadcrumb-list">items</x-slot:list></april:breadcrumb>');

        expect(substr_count($html, 'id="breadcrumb-list"'))->toBe(1);
    });

    it('renders an item as a list item', function () {
        expect(renderComponent('breadcrumb-item', '', 'Home'))
            ->toContain('<li')
            ->toContain('Home');
    });

    it('renders a link as an anchor', function () {
        expect(renderComponent('breadcrumb-link', 'href="/"', 'Home'))
            ->toContain('<a')
            ->toContain('href="/"');
    });

    it('renders the current page', function () {
        expect(renderComponent('breadcrumb-page', '', 'Settings'))->toContain('Settings');
    });

    it('renders a separator', function () {
        expect(renderComponent('breadcrumb-separator'))->toContain('<li');
    });

    it('renders an ellipsis', function () {
        expect(renderComponent('breadcrumb-elipsis'))->toBeString()->not->toBeEmpty();
    });
});

describe('icons', function () {
    it('renders the close icon as an svg', function () {
        expect(renderComponent('x'))->toContain('<svg');
    });

    it('renders the chevron icon as an svg', function () {
        expect(renderComponent('angle-down'))->toContain('<svg');
    });

    it('renders the loading spinner as an svg', function () {
        expect(renderComponent('loading-spinner'))->toContain('<svg');
    });

    it('takes a class on an icon', function (string $icon) {
        expect(renderComponent($icon, 'class="h-6 w-6"'))->toContain('h-6 w-6');
    })->with(['x', 'angle-down', 'loading-spinner']);

    it('lets a class on an icon win over the default size', function (string $icon, string $default, int $at) {
        expect(classesOf(renderComponent($icon, 'class="h-6 w-6"'), $at))
            ->toContain('h-6')
            ->toContain('w-6')
            ->not->toContain($default);
    })->with([
        ['x', 'h-3', 0],
        ['angle-down', 'h-3', 0],
        ['loading-spinner', 'h-10', 1],
    ]);

    it('applies the large icon size', function (string $icon, string $expected, int $at) {
        expect(classesOf(renderComponent($icon, 'size="lg"'), $at))->toContain($expected);
    })->with([
        ['x', 'w-5', 0],
        ['angle-down', 'w-5', 0],
        ['loading-spinner', 'w-13', 1],
    ]);

    it('does not leak the size attribute into the html', function (string $icon) {
        expect(renderComponent($icon, 'size="lg"'))->not->toContain('size="lg"');
    })->with(['x', 'angle-down', 'loading-spinner']);
});

describe('banner', function () {
    it('is driven by the alpine behaviour', function () {
        expect(renderComponent('banner'))->toContain('x-data');
    });

    it('renders the body slot', function () {
        $html = render('<april:banner><x-slot:body>Announcement</x-slot:body></april:banner>');

        expect($html)->toContain('Announcement');
    });

    it('positions itself at the top by default', function () {
        expect(classesOf(renderComponent('banner')))->toContain('top-0');
    });

    it('positions itself at the bottom on request', function () {
        expect(classesOf(renderComponent('banner', 'position="bottom"')))->toContain('bottom-0');
    });

    it('shows a dismiss trigger on request', function () {
        expect(renderComponent('banner', 'dismissable'))->toContain('x-bind="dismissTrigger"');
    });
});
