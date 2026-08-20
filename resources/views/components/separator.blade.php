@props(['orientation' => 'horizontal'])

<div data-orientation="{{$orientation}}" role="none" {{$attributes->merge(["data-slot" => "separator"])->twMerge([
    'shrink-0 bg-border',
    'h-[1px] w-full my-4' => $orientation == 'horizontal',
    'w-[1px] h-full mx-4' => $orientation == 'vertical',
])}}></div>
