@props([
    'label' => '',
    'value' => 0,
    'max' => 100,
    'color' => 'bg-primary',
])

@php
    $percentage = $max > 0 ? min(100, max(0, ($value / $max) * 100)) : 0;
@endphp

<div data-slot="chart-bar" class="flex min-w-0 flex-1 flex-col items-center gap-2">
    <div class="flex h-full w-full items-end rounded-md bg-muted/50">
        <div class="w-full rounded-md {{$color}} transition-[height] duration-300" style="height: {{$percentage}}%" title="{{$value}}"></div>
    </div>
    <span class="truncate text-xs text-muted-foreground">{{$label}}</span>
</div>
