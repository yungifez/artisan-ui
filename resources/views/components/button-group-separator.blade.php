@props(['orientation' => 'horizontal'])

<div data-slot="button-group-separator" role="separator"
    {{$attributes->twMerge(['z-10 bg-border', 'h-auto w-px' => $orientation !== 'vertical', 'h-px w-auto' => $orientation === 'vertical'])}}></div>
