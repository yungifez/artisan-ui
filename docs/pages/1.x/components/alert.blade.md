---
view: components.docs-layout
title: Alert
description: Displays a callout for user attention.
---

<x-component-preview component="previews.alert-demo"></x-component-preview>

## Destructive
<x-component-preview component="previews.alert-destructive-demo"></x-component-preview>

## Dismissable alert
The `alert` component supports being dismissed (ie the alert can be hidden when the close button is pressed).

<x-component-preview component="previews.alert-dismiss-demo"></x-component-preview>

## Dismiss On Timeout
Additionally, an alert can be dismissed after a timeout

<x-component-preview component="previews.alert-dismiss-on-timeout-demo"></x-component-preview>

You could also decide to start the timeout on intersect

<x-component-preview component="previews.alert-dismiss-on-intersect-timeout-demo"></x-component-preview>

## Heading level

The title renders as an `h2`, one level under the page heading. A reader who
moves by heading needs the levels to step down one at a time. Set `level` when
the alert sits inside a section that already holds a heading.

<x-code-block-wrapper language="blade">
@verbatim
<april:alert level="3">
    <slot:title>Heads up</slot:title>
    <slot:description>Your trial ends on Friday.</slot:description>
</april:alert>
@endverbatim
</x-code-block-wrapper>

### Props

| Prop | Type | Default | Description |
| --- | --- | --- | --- |
| `level` | `integer` | `2` | The heading level the title renders as. Accepts 1 to 6. |

<x-publish-command view="alert"/>
