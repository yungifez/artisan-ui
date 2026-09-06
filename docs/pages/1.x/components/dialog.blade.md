---
view: components.docs-layout
title: Dialog
description: A window overlaid on either the primary window or another dialog window, rendering the content underneath inert.
---

<x-component-preview component="previews.dialog-demo"></x-component-preview>

## Custom close button
<x-component-preview component="previews.dialog-custom-close-demo"></x-component-preview>

## Breaking out of parent context

To avoid Z-Index and other bizarre CSS issues (looking at you `backdrop-filter:blur`), the `dialog` component supports x-teleport provided by Alpine, you however do not need to wrap the dialog in a `template` element.

<x-component-preview component="previews.dialog-teleport-demo"></x-component-preview>

## Heading level

The title renders as an `h2`, one level under the page heading. A reader who
moves by heading needs the levels to step down one at a time. Set `level` when
the dialog sits inside a section that already holds a heading.

<x-code-block-wrapper language="blade">
@verbatim
<april:dialog-header level="3">
    <slot:title>Delete this file</slot:title>
    <slot:description>This cannot be undone.</slot:description>
</april:dialog-header>
@endverbatim
</x-code-block-wrapper>

### Props

| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `level` | `integer` | `2` | The heading level the title renders as. Accepts 1 to 6. |

<x-publish-command :views="['dialog', 'dialog-header', 'dialog-footer']"/>
