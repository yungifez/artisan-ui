<?php

describe('aspect ratio', function () {
    it('preserves the requested ratio and content', function () {
        $html = renderComponent('aspect-ratio', 'ratio="16/9"', 'Preview');

        expect($html)->toContain('data-slot="aspect-ratio"', 'style="aspect-ratio: 16/9;"', 'Preview');
    });
});

describe('attachments', function () {
    it('maps state, size, and orientation to the attachment surface', function () {
        $html = render('<april:attachment state="error" size="sm" orientation="vertical"><x-slot:content>File.pdf</x-slot:content></april:attachment>');

        expect($html)
            ->toContain('data-state="error"', 'data-orientation="vertical"', 'min-h-14', 'flex-col', 'File.pdf');
    });

    it('renders media, content, actions, and trigger slots in their own regions', function () {
        $html = render(<<<'BLADE'
<april:attachment>
    <x-slot:media>PDF</x-slot:media>
    <x-slot:content>Report.pdf</x-slot:content>
    <x-slot:actions><april:attachment-action>Remove</april:attachment-action></x-slot:actions>
    <x-slot:trigger><a href="/reports">Open</a></x-slot:trigger>
</april:attachment>
BLADE);

        expect($html)
            ->toContain('data-slot="attachment-media"', 'PDF')
            ->toContain('data-slot="attachment-content"', 'Report.pdf')
            ->toContain('data-slot="attachment-actions"', 'Remove')
            ->toContain('data-slot="attachment-trigger"', 'href="/reports"');
    });

    it('keeps attachment actions safe inside forms', function () {
        expect(renderComponent('attachment-action', '', 'Remove'))
            ->toContain('<button type="button"', 'Remove');
    });

    it('groups attachments with an accessible group role', function () {
        expect(renderComponent('attachment-group', '', 'files'))
            ->toContain('role="group"', 'files');
    });
});

describe('bubbles', function () {
    it('aligns and styles a bubble by its public props', function () {
        $html = renderComponent('bubble', 'variant="outline" align="end"', 'Hello');

        expect($html)
            ->toContain('data-variant="outline"', 'data-align="end"', 'ml-auto', 'border', 'Hello');
    });

    it('composes bubbles and reactions into their group containers', function () {
        $html = render('<april:bubble-group><april:bubble>One</april:bubble><april:bubble-reactions>👍</april:bubble-reactions></april:bubble-group>');

        expect($html)->toContain('data-slot="bubble-group"', 'data-slot="bubble"', 'data-slot="bubble-reactions"');
    });
});

describe('button groups', function () {
    it('changes its layout and keeps group semantics', function () {
        $html = render('<april:button-group orientation="vertical"><april:button>One</april:button></april:button-group>');

        expect($html)->toContain('role="group"', 'data-orientation="vertical"', 'flex-col', 'One');
    });

    it('orients its separator independently', function () {
        expect(renderComponent('button-group-separator', 'orientation="vertical"'))
            ->toContain('role="separator"', 'h-px', 'w-auto');
    });

    it('renders group text without turning it into a button', function () {
        $html = renderComponent('button-group-text', '', 'Status');

        expect($html)->toContain('<span', 'data-slot="button-group-text"', 'Status')
            ->not->toContain('<button');
    });
});

describe('carousel items and chart bars', function () {
    it('renders a labelled carousel region with its controls', function () {
        $html = render('<april:carousel label="Featured"><april:carousel-item>Slide</april:carousel-item></april:carousel>');

        expect($html)->toContain('role="region"', 'aria-roledescription="carousel"', 'aria-label="Featured"', 'Slide');
    });

    it('marks carousel items as slides', function () {
        expect(renderComponent('carousel-item', '', 'Slide one'))
            ->toContain('role="group"', 'aria-roledescription="slide"', 'Slide one');
    });

    it('clamps chart bar percentages to the visible range', function () {
        $low = renderComponent('chart-bar', 'label="Low" value="-5" max="100"');
        $high = renderComponent('chart-bar', 'label="High" value="150" max="100"');

        expect($low)->toContain('style="height: 0%"', 'title="-5"', 'Low')
            ->and($high)->toContain('style="height: 100%"', 'title="150"', 'High');
    });
});

describe('composite subcomponents', function () {
    it('closes an alert dialog from both action components', function () {
        $html = render(<<<'BLADE'
<april:alert-dialog>
    <x-slot:trigger>Open</x-slot:trigger>
    <x-slot:content>
        <april:alert-dialog-header>Confirm</april:alert-dialog-header>
        <april:alert-dialog-footer>
            <april:alert-dialog-cancel>Cancel</april:alert-dialog-cancel>
            <april:alert-dialog-action>Continue</april:alert-dialog-action>
        </april:alert-dialog-footer>
    </x-slot:content>
</april:alert-dialog>
BLADE);

        expect($html)
            ->toContain('data-slot="alert-dialog-cancel"', 'data-slot="alert-dialog-action"')
            ->and(substr_count($html, 'type="button"'))->toBeGreaterThanOrEqual(2);
    });

    it('keeps dropdown groups accessible', function () {
        expect(renderComponent('dropdown-menu-group', '', 'Menu choices'))
            ->toContain('role="group"', 'Menu choices');
    });

    it('keeps context menu items keyboard and form safe', function () {
        expect(renderComponent('context-menu-item', '', 'Copy'))
            ->toContain('<button type="button"', 'role="menuitem"', 'Copy');
    });

    it('renders a named context menu trigger without losing the content slot', function () {
        $html = render(<<<'BLADE'
<april:context-menu>
    <x-slot:trigger><button type="button">Right click</button></x-slot:trigger>
    <x-slot:content><april:context-menu-item>Copy</april:context-menu-item></x-slot:content>
</april:context-menu>
BLADE);

        expect($html)
            ->toContain('data-slot="context-menu-trigger"', 'Right click')
            ->toContain('data-slot="context-menu-content"', 'Copy');
    });

    it('renders context menu labels and separators with their semantics', function () {
        expect(renderComponent('context-menu-label', '', 'File'))
            ->toContain('data-slot="context-menu-label"', 'File');
        expect(renderComponent('context-menu-separator'))
            ->toContain('role="separator"', 'data-slot="context-menu-separator"');
    });

    it('keeps data table parts usable in the server-rendered composition', function () {
        $html = render(<<<'BLADE'
<april:data-table caption="People">
    <x-slot:header><tr><th>Name</th></tr></x-slot:header>
    <x-slot:body><tr><td>Ada</td></tr></x-slot:body>
</april:data-table>
BLADE);

        expect($html)
            ->toContain('data-slot="data-table"', 'data-slot="data-table-caption"', 'People')
            ->toContain('data-slot="data-table-header"', 'data-slot="data-table-body"', 'Ada');
    });

    it('renders data table head, row, and cell parts with table semantics', function () {
        expect(renderComponent('data-table-head', '', 'Name'))
            ->toContain('<th', 'scope="col"', 'Name');
        expect(renderComponent('data-table-row', '', '<td>Row</td>'))
            ->toContain('<tr', 'Row');
        expect(renderComponent('data-table-cell', '', 'Value'))
            ->toContain('<td', 'Value');
    });
});
