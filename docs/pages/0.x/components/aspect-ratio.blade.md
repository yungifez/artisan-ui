---
view: components.docs-layout
title: Aspect Ratio
description: Displays content inside a box with a consistent width-to-height ratio.
---

<x-component-preview component="previews.aspect-ratio-demo"></x-component-preview>

Pass a CSS aspect-ratio value through the `ratio` attribute. The component uses its default slot for the content it constrains.

<x-code-block-wrapper language="blade">
@verbatim
<april:aspect-ratio ratio="16 / 9">
    <img src="/image.jpg" alt="A landscape" class="h-full w-full object-cover" />
</april:aspect-ratio>
@endverbatim
</x-code-block-wrapper>

<x-publish-command view="aspect-ratio" />
