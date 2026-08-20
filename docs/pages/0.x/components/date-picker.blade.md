---
view: components.docs-layout
title: Date Picker
description: A date picker component.
---
<x-component-preview component="previews.date-picker-demo"></x-component-preview>

The date picker is built using the `calendar` component, the `mode`, `required`, and `value` attributes are passed as attributes to the calendar component, other attributes are passed to the hidden input element(s), and visible button element.

<x-callout>
When in `range` mode, the names of the `for`/`to` hidden attributes is gotten by a concatenation of the name attribute and `['from']`/`['to']` respectively. For example, if the name given to the date-picker is `example`, the names of the for and to input fields are `example['from']` and `example['to']` respectively

You can override the default names of the `from`, and 'to' attribute by including the `from-name` and `to-name` respectively

</x-callout>

<x-publish-command view="date-picker"/>
