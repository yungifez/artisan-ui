---
view: components.docs-layout
title: Banner
description: Displays a temporary message at the top or bottom of an application.
---

<x-component-preview component="previews.banner-demo"></x-component-preview>

The banner is hidden on first render, then displays after `display-after` milliseconds. Use the `body` slot for the message and add `dismissable` when the user should be able to close it.

<x-code-block-wrapper language="blade">
@verbatim
<april:banner position="top" display-after="500" dismissable>
    <x-slot:body>
        Your trial ends in three days.
    </x-slot:body>
</april:banner>
@endverbatim
</x-code-block-wrapper>

Set `position="bottom"` to anchor the banner to the bottom of the viewport. Set `position="none"` when the banner belongs inside a contained layout.

<x-publish-command view="banner" />
