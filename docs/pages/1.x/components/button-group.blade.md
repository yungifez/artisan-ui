---
view: components.docs-layout
title: Button Group
description: Groups related buttons together with consistent spacing and borders.
---

<x-component-preview component="previews.button-group-demo"></x-component-preview>

Place buttons in the default slot. Set `orientation="vertical"` for a stacked group and label the group with `aria-label` or `aria-labelledby`.

<x-code-block-wrapper language="blade">
@verbatim
<april:button-group aria-label="Actions">
    <april:button variant="outline">Archive</april:button>
    <april:button variant="outline">Report</april:button>
</april:button-group>
@endverbatim
</x-code-block-wrapper>

<x-publish-command :views="['button-group', 'button-group-separator', 'button-group-text']" />
