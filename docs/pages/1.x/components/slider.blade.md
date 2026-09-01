---
view: components.docs-layout
title: Slider
description: Lets a user choose a numeric value from a range.
---

<x-component-preview component="previews.slider-demo"></x-component-preview>

The slider is a styled native range input. Use the standard range attributes to define its value and bounds.

<x-code-block-wrapper language="blade">
@verbatim
<april:slider
    name="volume"
    aria-label="Volume"
    min="0"
    max="100"
    step="5"
    value="60"
/>
@endverbatim
</x-code-block-wrapper>

Native range input behavior and events remain available, including `input` and `change`.

<x-publish-command view="slider" />
