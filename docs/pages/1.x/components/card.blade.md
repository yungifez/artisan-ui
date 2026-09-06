---
view: components.docs-layout
title: Card
description: Displays a card with header, content, and footer.
---
<x-component-preview component="previews.card-demo"></x-component-preview>


## Heading level

The title renders as an `h2`, one level under the page heading. A reader who
moves by heading needs the levels to step down one at a time. Set `level` when
the card sits inside a section that already holds a heading.

<x-code-block-wrapper language="blade">
@verbatim
<april:card level="3">
    <slot:title>Billing</slot:title>
    <slot:content>Your plan renews monthly.</slot:content>
</april:card>
@endverbatim
</x-code-block-wrapper>

### Props

| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `level` | `integer` | `2` | The heading level the title renders as. Accepts 1 to 6. |

<x-publish-command view="card"/>
