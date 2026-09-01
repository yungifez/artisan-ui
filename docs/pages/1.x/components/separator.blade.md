---
view: components.docs-layout
title: Separator
description: Separates content with a horizontal or vertical rule.
---

<x-component-preview component="previews.separator-demo"></x-component-preview>

The separator is horizontal by default. Set `orientation="vertical"` when it sits between items in a row.

<x-code-block-wrapper language="blade">
@verbatim
<april:separator />
<april:separator orientation="vertical" class="h-6" />
@endverbatim
</x-code-block-wrapper>

Use the component's classes and semantic color tokens to match the surrounding surface.

<x-publish-command view="separator" />
