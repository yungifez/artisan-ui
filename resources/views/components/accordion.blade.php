@props([
    'type' => 'multiple',
    'collapsible' => false,
    'disabled' => false,
])

<div data-slot="accordion" x-data="accordion('{{$type}}', {{$collapsible ? 'true' : 'false'}}, {{$disabled ? 'true' : 'false'}})"
    {{$attributes->twMerge(['w-full'])}}>
    {{$slot}}
</div>
