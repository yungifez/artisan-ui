@props(['orientation' => 'horizontal'])

<div data-orientation="{{$orientation}}" role="none" {{$attributes->twMerge(['shrink-0 bg-border w-full my-4', 'h-[1px]
    w-full' => $orientation == 'horizontal', 'h-[1px] w-full' => $orientation == 'vertical'])}}></div>
