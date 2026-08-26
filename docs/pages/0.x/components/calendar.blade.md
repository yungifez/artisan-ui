---
view: components.docs-layout
title: Calendar
description: A date field component that allows users to enter and edit date.
---

<x-component-preview component="previews.calendar-demo"></x-component-preview>

<x-callout>
    This calendar was inspired by the **[React DayPicker](https://react-day-picker.js.org/)** and follows the same composable conventions as [shadcn/ui's calendar](https://ui.shadcn.com/docs/components/calendar).
</x-callout>

The calendar supports single, multiple, and range selection, keyboard navigation, month/year controls, and disabled-date matchers.

| Prop | Type | Description |
|---|---|---|
| `mode` | `"single"` \| `"multiple"` \| `"range"` | Selection mode. Defaults to `single`. |
| `selected` | `string` \| `Date` \| mode-specific array | Initial selection. |
| `disabled` | `array` | Disabled-date matchers. |
| `required` | `boolean` | Prevent clearing the current selection. |

## Common configurations

The default calendar keeps the original April UI appearance. These options add common shadcn calendar variants without requiring a different component.

| Prop | Type | Description |
|---|---|---|
| `captionLayout` | `"label"` \| `"dropdown"` \| `"dropdown-months"` \| `"dropdown-years"` | Text labels or native month/year selectors. |
| `showOutsideDays` | `boolean` | Render days from adjacent months. Defaults to `true`. |
| `fixedWeeks` | `boolean` | Keep six rows for a stable height. Defaults to `true`. |
| `showWeekNumber` | `boolean` | Add ISO week numbers to the grid. |
| `numberOfMonths` | `int` | Render up to twelve consecutive months. |
| `pagedNavigation` | `boolean` | Move by the number of visible months. |
| `weekStartsOn` | `0`–`6` | First weekday (`0` is Sunday). |
| `defaultMonth` | `string` \| `Date` | Month shown when no selection exists. |
| `fromMonth` / `startMonth` | `string` \| `Date` | Earliest navigable month. |
| `toMonth` / `endMonth` | `string` \| `Date` | Latest navigable month. |
| `fromYear` / `toYear` | `int` | Bounds for the year dropdown. |
| `hideNavigation` | `boolean` | Hide previous/next controls. |

The component emits both `change` and `select` with `{ detail: { value } }`, so existing Alpine listeners continue to work:

```blade
<april:calendar
    captionLayout="dropdown"
    :showWeekNumber="true"
    :showOutsideDays="false"
    :fromYear="now()->subYears(2)->year"
    :toYear="now()->addYears(2)->year"
    @select="console.log($event.detail.value)"
/>
```

### Dropdown caption and week numbers

<x-component-preview component="previews.calendar-options-demo"></x-component-preview>

### Multiple months

<x-component-preview component="previews.calendar-multiple-months-demo"></x-component-preview>

## Selection modes

### Single mode

When `mode="single"`, one day can be selected at a time. The `select` event's `$event.detail.value` contains a JavaScript `Date` or `null`.

<x-component-preview component="previews.calendar-single-demo"></x-component-preview>

| Prop | Type | Description |
|---|---|---|
| `@select` | `Alpine event listener` | Runs when the selected day changes. |
| `required` | `boolean` | Ensures a selected day cannot be cleared. |

### Multiple mode

When `mode="multiple"`, users can select several days. The event value is an array of JavaScript `Date` objects.

<x-component-preview component="previews.calendar-multiple-demo"></x-component-preview>

Use `max` to limit the number of selected days.

```blade
<april:calendar mode="multiple" max="5" />
```

<x-component-preview component="previews.calendar-multiple-max-demo"></x-component-preview>

### Range mode

When `mode="range"`, the event value is an object with `from` and `to` JavaScript `Date` values. `min` and `max` limit the number of days between the endpoints.

<x-component-preview component="previews.calendar-range-demo"></x-component-preview>

Use `min` and `max` to constrain the length of the selected range:

```blade
<april:calendar mode="range" min="3" max="14" />
```

<x-component-preview component="previews.calendar-range-max-min-demo"></x-component-preview>

## Disabling dates

Pass an array of matcher objects to `disabled`. A `dates` matcher disables exact dates, `before`/`after` disables a range (the boundary itself remains enabled), and `dayOfWeek` accepts a number or an array from `0` (Sunday) to `6` (Saturday).

<x-component-preview component="previews.calendar-disabled-dates-demo"></x-component-preview>
<x-component-preview component="previews.calendar-disabled-range-demo"></x-component-preview>
<x-component-preview component="previews.calendar-disabled-day-of-week-demo"></x-component-preview>
<x-component-preview component="previews.calendar-disabled-multiple-demo"></x-component-preview>

The same matcher types can be used independently:

```blade
<april:calendar :disabled="[
    ['dates' => [now(), now()->addDay()]],
    ['before' => now()],
    ['dayOfWeek' => [0, 6]],
]" />
```

<x-publish-command view="calendar"/>
