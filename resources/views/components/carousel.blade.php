@props([
    'orientation' => 'horizontal',
    'loop' => true,
    'label' => 'Carousel',
])

<div data-slot="carousel" role="region" aria-roledescription="carousel" aria-label="{{$label}}" tabindex="0"
    x-data="carousel('{{$orientation}}', {{ $loop ? 'true' : 'false' }})" x-bind="root" {{$attributes->twMerge(['relative'])}}>
    <div data-slot="carousel-viewport" x-bind="viewport" class="overflow-hidden">
        <div data-slot="carousel-track" x-bind="track" class="flex transition-transform duration-300 ease-in-out {{ $orientation === 'vertical' ? 'flex-col' : '' }}">
            {{$slot}}
        </div>
    </div>

    @isset($previous)
        <div data-slot="carousel-previous" x-bind="previous">
            {{$previous}}
        </div>
    @else
        <button type="button" data-slot="carousel-previous" x-bind="previous" class="absolute left-2 top-1/2 inline-flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full border bg-background text-sm shadow-sm transition-colors hover:bg-accent disabled:pointer-events-none disabled:opacity-50" aria-label="Previous slide">
            <span aria-hidden="true">←</span>
        </button>
    @endisset

    @isset($next)
        <div data-slot="carousel-next" x-bind="next">
            {{$next}}
        </div>
    @else
        <button type="button" data-slot="carousel-next" x-bind="next" class="absolute right-2 top-1/2 inline-flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full border bg-background text-sm shadow-sm transition-colors hover:bg-accent disabled:pointer-events-none disabled:opacity-50" aria-label="Next slide">
            <span aria-hidden="true">→</span>
        </button>
    @endisset
</div>
