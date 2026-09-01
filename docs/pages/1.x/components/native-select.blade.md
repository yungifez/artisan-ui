---
view: components.docs-layout
title: Native Select
description: Displays a styled browser-native select control.
---

<x-component-preview component="previews.native-select-demo"></x-component-preview>

Use the native select when you want the browser to own option rendering, keyboard behavior, and mobile selection UI.

<x-code-block-wrapper language="blade">
@verbatim
<april:native-select name="fruit" aria-label="Fruit">
    <option value="apple">Apple</option>
    <option value="banana">Banana</option>
</april:native-select>
@endverbatim
</x-code-block-wrapper>

Native `select` and `option` attributes pass through as usual.

<x-publish-command view="native-select" />
