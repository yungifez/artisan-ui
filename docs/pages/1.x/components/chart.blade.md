---
view: components.docs-layout
title: Chart
description: Responsive Alpine charts with shadcn-style config, tooltips, legends, and theme tokens.
---

<x-component-preview component="previews.chart-demo"></x-component-preview>

Charts follow shadcn's data/config model. `data` holds the values while `config` holds labels and colors. The chart draws a grid, axes, legend, and hover or keyboard tooltip without a JavaScript chart dependency.

<x-code-block-wrapper language="blade">
@verbatim
@php
    $data = [
        ['month' => 'Jan', 'desktop' => 186, 'mobile' => 80],
        ['month' => 'Feb', 'desktop' => 305, 'mobile' => 200],
    ];

    $config = [
        'desktop' => ['label' => 'Desktop', 'color' => 'var(--chart-1)'],
        'mobile' => ['label' => 'Mobile', 'color' => 'var(--chart-2)'],
    ];
@endphp

<april:chart label="Monthly visitors" :data="$data" :config="$config" xKey="month">
</april:chart>
@endverbatim
</x-code-block-wrapper>

Set `type="line"` or `type="area"` to change the chart geometry. The default is `bar`. The five theme-aware color tokens are `var(--chart-1)` through `var(--chart-5)`.

Use the left and right arrow keys while the chart is focused to inspect each data point. The existing `chart-bar` component remains available as a static fallback when you do not pass `data`.

<x-publish-command :views="['chart', 'chart-bar']" />
