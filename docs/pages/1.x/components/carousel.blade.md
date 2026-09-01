---
view: components.docs-layout
title: Carousel
description: A slideshow for cycling through a collection of content.
---

<x-component-preview component="previews.carousel-demo"></x-component-preview>

Use `carousel-item` for each slide. The default slot is a collection, so each repeated slide is a child component. The carousel supports horizontal and vertical orientation and can loop or stop at its bounds.

<x-code-block-wrapper language="blade">
@verbatim
<april:carousel>
    <april:carousel-item>First slide</april:carousel-item>
    <april:carousel-item>Second slide</april:carousel-item>
</april:carousel>
@endverbatim
</x-code-block-wrapper>

Set `orientation="vertical"` for a vertical carousel or use `:loop="false"` to disable wrapping.

<x-publish-command :views="['carousel', 'carousel-item']" />
