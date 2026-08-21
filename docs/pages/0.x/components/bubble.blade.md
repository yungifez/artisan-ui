---
view: components.docs-layout
title: Bubble
description: Displays conversational content in a message bubble.
---

<x-component-preview component="previews.bubble-demo"></x-component-preview>

The default slot is the bubble's primary content. Use `align` and `variant` to change its position and visual treatment. Use `bubble-group` for a sequence of related bubbles.

<x-code-block-wrapper language="blade">
@verbatim
<april:bubble variant="secondary" align="end">
    I will review it now.
    <slot:reactions>👍</slot:reactions>
</april:bubble>
@endverbatim
</x-code-block-wrapper>

<x-publish-command :views="['bubble', 'bubble-group', 'bubble-reactions']" />
