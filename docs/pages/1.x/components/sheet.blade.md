---
view: components.docs-layout
title: Sheet
description:  Extends the Dialog component to display content that complements the main content of the screen.
---

<x-component-preview component="previews.sheet-demo"></x-component-preview>

## Side

Use the side attribute in the `sheet` slot to indicate the edge of the screen where the component will appear. The values can be top, right, bottom or left.

<x-component-preview component="previews.sheet-side-demo"></x-component-preview>

## Heading level

The title renders as an `h2`, one level under the page heading. A reader who
moves by heading needs the levels to step down one at a time. Set `level` when
the sheet sits inside a section that already holds a heading.

<x-code-block-wrapper language="blade">
@verbatim
<april:sheet-header level="3">
    <slot:title>Menu</slot:title>
    <slot:description>Go to a section.</slot:description>
</april:sheet-header>
@endverbatim
</x-code-block-wrapper>

### Props

| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `level` | `integer` | `2` | The heading level the title renders as. Accepts 1 to 6. |

<x-publish-command :views="[
    'sheet',
    'sheet-header',
    'sheet-footer'
]" />
