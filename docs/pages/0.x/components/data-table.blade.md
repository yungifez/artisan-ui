---
view: components.docs-layout
title: Data Table
description: A semantic table composition for displaying structured data.
---

<x-component-preview component="previews.data-table-demo"></x-component-preview>

The caption, header, and body are named slots because each is one table region. Rows and cells can repeat, so they use dedicated child components in the default slot of each region.

<x-code-block-wrapper language="blade">
@verbatim
<april:data-table>
    <slot:header>
        <april:data-table-row>
            <april:data-table-head>Name</april:data-table-head>
            <april:data-table-head>Email</april:data-table-head>
        </april:data-table-row>
    </slot:header>
    <slot:body>
        <april:data-table-row>
            <april:data-table-cell>Olivia Martin</april:data-table-cell>
            <april:data-table-cell>olivia@example.com</april:data-table-cell>
        </april:data-table-row>
    </slot:body>
</april:data-table>
@endverbatim
</x-code-block-wrapper>

Use the `caption` attribute or `caption` named slot to describe the table.

<x-publish-command :views="['data-table', 'data-table-row', 'data-table-head', 'data-table-cell']" />
