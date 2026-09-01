---
view: components.docs-layout
title: Date Picker
description: A date picker component.
---
<x-component-preview component="previews.date-picker-demo"></x-component-preview>

The date picker is built using the `calendar` component. Use `mode`, `required`, and `value` to configure it. Use `name`, `from-name`, and `to-name` for form field names. Other attributes are applied to the date-picker root and are not duplicated on its hidden inputs.

<x-callout>
When in `range` mode, the names of the `from`/`to` hidden inputs are made by concatenating the name attribute with `['from']`/`['to']`. For example, if the name is `example`, the input names are `example['from']` and `example['to']`.

You can override the default names of the `from`, and 'to' attribute by including the `from-name` and `to-name` respectively

</x-callout>

<x-publish-command view="date-picker"/>
