@props(['orientation' => 'horizontal'])

@php
$orientationClass = $orientation === 'vertical' ? 'flex-col [&>*:not(:first-child)]:-mt-px' : 'flex-row [&>*:not(:first-child)]:-ml-px';
$radiusClass = $orientation === 'vertical'
    ? '[&>button]:first:rounded-t-md [&>button]:last:rounded-b-md'
    : '[&>button]:first:rounded-l-md [&>button]:last:rounded-r-md';
@endphp

<div data-slot="button-group" role="group" data-orientation="{{$orientation}}"
    {{$attributes->twMerge(["inline-flex $orientationClass $radiusClass [&>button]:relative [&>button]:z-0 [&>button]:rounded-none [&>button]:hover:z-10 focus-within:[&>button]:z-10"])}}>
    {{$slot}}
</div>
