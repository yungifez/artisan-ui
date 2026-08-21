@props([
    'label' => 'Chart',
])

<div data-slot="chart" role="img" aria-label="{{$label}}" {{$attributes->twMerge(['rounded-lg border bg-card p-6 text-card-foreground'])}}>
    @isset($header)
        <div data-slot="chart-header" class="mb-6 flex flex-col gap-1">
            {{$header}}
        </div>
    @endisset

    <div data-slot="chart-content" class="flex h-64 items-end gap-3">
        {{$slot}}
    </div>
</div>
