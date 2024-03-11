@props([
    'class' => '',
    'size' => 'w-10 h-10',
    'src' => '',
    'fallback' => '',
    'borderRadius' => "rounded-full ",
    "groupClass" => ''
])

<div x-data="{loadError: false}" class="{{$groupClass}} {{$size}} {{$borderRadius}} aspect-square border flex justify-center items-center" {{$attributes->whereStartsWith("group")}}>
    <img
        class="{{$class}} rounded-full"
        {{$attributes->whereDoesntStartWith(["fallback", "group"])}}
        x-show="!loadError"
        x-on:error="loadError = true"
        src="{{$src}}"

    >
    <div
        x-show="loadError"
        class="{{$class}} p-3"
        {{$attributes->whereStartsWith("fallback")}}
    >
        {{$fallback}}
    </div>
</div>
