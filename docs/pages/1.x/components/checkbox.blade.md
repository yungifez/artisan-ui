---
view: components.docs-layout
title: Checkbox
description: Displays a native checkbox with April UI styling.
---

<x-component-preview component="previews.checkbox-demo"></x-component-preview>

The checkbox is a styled input. Use a label with a matching `for` and `id` so the complete control remains easy to use with a pointer or keyboard.

<x-code-block-wrapper language="blade">
@verbatim
<april:checkbox id="updates" name="updates" value="1" />
<april:label for="updates">Send me product updates</april:label>
@endverbatim
</x-code-block-wrapper>

All native input attributes, including `checked`, `disabled`, `required`, and `value`, are passed through.

<x-publish-command view="checkbox" />
