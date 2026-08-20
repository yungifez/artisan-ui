---
view: components.docs-layout
title: Calendar
description: A date field component that allows users to enter and edit date.
---

<x-component-preview component="previews.calendar-demo"></x-component-preview>

<x-callout>
    This calendar was inspired by the **[React DayPicker](https://react-day-picker.js.org/)**
</x-callout>

The calendar supports multiple modes, it also allows disabling certain dates

| Prop        | Type                                      | Description                               |
|-------------|-------------------------------------------|-------------------------------------------|
|  `mode`     |  `"single"` \| `"multiple"` \| `"range"`  |  Set a selection mode, defaults to single |
| `disabled`  | `array` <br> More info below              |  Disabled days that cannot be selected.   |

## Selection Modes
The calendar supports 3 modes
- Single mode
- Multiple mode
- Range mode

### Single mode

When in single mode ie when `mode="single"`, only one day can be selected at a time. You can listen for the `select` event using alpine Js triggered when a date has been selected. The $event object contains a details.value containing a JavaScript date object of the selected day

<x-component-preview component="previews.calendar-single-demo"></x-component-preview>

| Prop        | Type                      | Description                                 |
|-------------|---------------------------|---------------------------------------------|
| `selected`  |  `"string"` \| `"Date"`   |  The date to be selected initially.         |
| `@select`   | `Alpine event listener`   |  Event Listener for when a date is selected |
| `required`  |  `"boolean"`              |  Ensures at least 1 date is chosen.         |


### Multiple mode

When in multiple mode ie when `mode="multiple"`, multiple days can be selected at once. You can listen for the `select` event using alpine triggered when one or more dates have been selected. The $event object contains a details.value containing an array of JavaScript date objects of the selected days.

<x-component-preview component="previews.calendar-multiple-demo"></x-component-preview>

You can also pass a max which specifies the maximum number of items selectable

<x-component-preview component="previews.calendar-multiple-max-demo"></x-component-preview>

| Prop        | Type                      | Description                                 |
|-------------|---------------------------|---------------------------------------------|
| `selected`  |`"string[]"` \| `"Date[]"` |  The date to be selected initially.         |
| `max`       | `"int"`                   |  The maximum selectable items.              |
| `@select`   | `Alpine event listener`   |  Event Listener for when a date is selected.|

### Range mode

When in range mode ie when `mode="range"`, a `from` and `to` date is to be selected such that the `from` is an earlier date than the `to` date. You can listen for the `select` event using alpine triggered when a from and to date have been selected. The $event object contains a details.value containing an array of JavaScript date objects of the selected days.

<x-component-preview component="previews.calendar-range-demo"></x-component-preview>

Just like in multiple mode, you can pass a `max` and `min`. The `max` and `min` attributes represent the maximum and minimum days from the from date that can be selected respectively

<x-component-preview component="previews.calendar-range-max-min-demo"></x-component-preview>

| Prop        | Type                      | Description                                      |
|-------------|---------------------------|--------------------------------------------------|
| `selected`  |`"array with from and to " |  The date to be selected initially.              |
| `min`       | `"int"`                   |  The minimum amount of dates between from and to.|
| `max`       | `"int"`                   |  The maximum amount of dates between from and to.|
| `@select`   | `Alpine event listener`   |  Event Listener for when a date is selected.     |
| `required`  |  `"boolean"`              |  Ensures from date is chosen at least.           |


## Disabling dates

You can disable certain dates by passing an array of rules to the disabled attribute

### Disabling certain dates

To disable certain days, an array with the key `dates` and values of the dates you'll like to disable should be passed to the disabled attribute.

<x-component-preview component="previews.calendar-disabled-dates-demo"></x-component-preview>

### Disabling a range of days

To disable a range of days, an array with a `before` and `after` is passed to the disabled attribute. 

<x-callout>
Note that the `before` and `after` dates are not disabled
</x-callout>

<x-component-preview component="previews.calendar-disabled-range-demo"></x-component-preview>

### Disabling day of the week

To disable a range of days, an array with a `dayOfWeek` key and an int value from `0 - 6` is passed, where `0` represents sunday, and `6` represents saturday

<x-component-preview component="previews.calendar-disabled-day-of-week-demo"></x-component-preview>

### Multiple disable rules

You can pass an array of these rules to disable dates based on multiple rules

<x-component-preview component="previews.calendar-disabled-multiple-demo"></x-component-preview>


<x-publish-command view="calendar"/>
