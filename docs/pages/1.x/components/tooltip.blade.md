---
view: components.docs-layout
title: Tooltip
description: A popup that displays information related to an element when the element receives keyboard focus or the mouse hovers over it.
---

<x-component-preview component="previews.tooltip-demo"></x-component-preview>

---

## Silencing a tooltip

Pass `:disabled="true"` to keep a tooltip mounted but quiet. Bind it when a tooltip only helps some of the time, such
as a sidebar label that the reader can already see once the sidebar opens.

<x-code-block-wrapper language="blade">
@verbatim
<april:tooltip x-effect="tooltipDisabled = sidebar.state !== 'collapsed'">
    <slot:trigger>...</slot:trigger>
    <slot:content>Boarding</slot:content>
</april:tooltip>
@endverbatim
</x-code-block-wrapper>

A silenced tooltip keeps its trigger and its `aria-describedby`, so nothing moves on the page when you turn it off.

<x-publish-command view="tooltip" />
