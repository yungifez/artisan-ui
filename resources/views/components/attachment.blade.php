@props([
    'state' => 'done',
    'size' => 'default',
    'orientation' => 'horizontal',
])

@php
$sizeClass = match ($size) {
    'sm' => 'min-h-14 gap-2 p-2 text-sm',
    'xs' => 'min-h-10 gap-2 p-1.5 text-xs',
    default => 'min-h-20 gap-3 p-3',
};

$stateClass = match ($state) {
    'error' => 'border-destructive/50 text-destructive',
    'uploading', 'processing' => 'border-primary/40',
    default => 'bg-background',
};

$orientationClass = $orientation === 'vertical' ? 'flex-col items-stretch' : 'items-center';
@endphp

<div data-slot="attachment" data-state="{{$state}}" data-orientation="{{$orientation}}"
    {{$attributes->twMerge(["relative flex w-full rounded-lg border $sizeClass $stateClass $orientationClass"])}}>
    @isset($media)
    <div data-slot="attachment-media" {{$media->attributes->twMerge(['flex shrink-0 items-center justify-center overflow-hidden rounded-md bg-muted [&>svg]:size-5'])}}>
        {{$media}}
    </div>
    @endisset
    @isset($content)
    <div data-slot="attachment-content" {{$content->attributes->twMerge(['min-w-0 flex-1'])}}>
        {{$content}}
    </div>
    @endisset
    @isset($actions)
    <div data-slot="attachment-actions" {{$actions->attributes->twMerge(['flex shrink-0 items-center gap-1'])}}>
        {{$actions}}
    </div>
    @endisset
    @isset($trigger)
    <div data-slot="attachment-trigger" {{$trigger->attributes->twMerge(['absolute inset-0 z-0'])}}>
        {{$trigger}}
    </div>
    @endisset
</div>
