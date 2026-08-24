@props([
    'label' => 'Chart',
    'data' => [],
    'config' => [],
    'type' => 'bar',
    'xKey' => '',
    'height' => 240,
    'showLegend' => true,
])

@php
    $hasData = is_countable($data) && count($data) > 0;
@endphp

<div data-slot="chart" role="region" aria-label="{{$label}}"
    x-data='chart(@json($data), @json($config), @json($type), @json($xKey), @json((int) $height))' x-bind="root"
    {{$attributes->twMerge(['rounded-lg border bg-card p-6 text-card-foreground'])}}>
    @isset($header)
        <div data-slot="chart-header" class="mb-6 flex flex-col gap-1">
            {{$header}}
        </div>
    @endisset

    @if ($hasData)
        <div data-slot="chart-content" x-ref="chartContent" class="relative w-full" style="height: {{$height}}px">
            <svg x-ref="chart" x-bind="svg" tabindex="0" role="img" class="h-full w-full overflow-visible">
                {{-- Alpine cannot clone x-for templates inside SVG in every browser, so the SVG groups are generated as markup. --}}
                <g aria-hidden="true" x-html="gridMarkup"></g>
                <g aria-hidden="true" x-html="labelsMarkup"></g>
                <g aria-hidden="true" x-html="geometryMarkup"></g>
            </svg>

            <div data-slot="chart-tooltip" x-cloak x-show="activeDatum" x-transition.opacity x-bind:style="tooltipStyle"
                class="pointer-events-none absolute top-2 z-10 min-w-32 -translate-x-1/2 rounded-md border bg-popover px-3 py-2 text-xs text-popover-foreground shadow-md">
                <p class="mb-1 font-medium" x-text="activeIndex === null ? '' : category(activeIndex)"></p>
                <template x-for="row in tooltipRows" :key="`tooltip-${row.key}`">
                    <div class="flex items-center justify-between gap-4">
                        <span class="flex items-center gap-1.5 text-muted-foreground">
                            <span class="size-2 rounded-sm" :style="`background-color: ${row.color}`"></span>
                            <span x-text="row.label"></span>
                        </span>
                        <span class="font-mono font-medium tabular-nums" x-text="formatValue(row.value)"></span>
                    </div>
                </template>
            </div>
        </div>

        @if ($showLegend)
            <div data-slot="chart-legend" class="mt-4 flex flex-wrap justify-center gap-x-4 gap-y-2 text-sm">
                <template x-for="seriesItem in series" :key="`legend-${seriesItem.key}`">
                    <span class="flex items-center gap-1.5 text-muted-foreground">
                        <span class="size-2 rounded-sm" :style="`background-color: ${seriesItem.color}`"></span>
                        <span x-text="seriesItem.label"></span>
                    </span>
                </template>
            </div>
        @endif
    @else
        <div data-slot="chart-content" class="flex h-64 items-end gap-3">
            {{$slot}}
        </div>
    @endif
</div>
