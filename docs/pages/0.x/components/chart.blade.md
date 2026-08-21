---
view: components.docs-layout
title: Chart
description: A lightweight composable chart built from accessible HTML and CSS.
---

<x-component-preview component="previews.chart-demo"></x-component-preview>

The chart header is a named slot because it is one auxiliary region. Add one `chart-bar` child for each value. The bars are separate components because a chart contains multiple repeated values.

<x-code-block-wrapper language="blade">
@verbatim
<april:chart label="Monthly signups">
    <slot:header>
        <h3>Monthly signups</h3>
    </slot:header>
    <april:chart-bar label="Jan" value="48" />
    <april:chart-bar label="Feb" value="72" />
</april:chart>
@endverbatim
</x-code-block-wrapper>

Use `max` to scale values against a custom maximum and `color` to set the bar color.

<x-publish-command :views="['chart', 'chart-bar']" />
