@props([
    'class' => '',
    'fallback',
    'borderRadius' => "rounded-full",
])

@php
    $class .= " ".match($attributes->get("size")){
        default => "h-10 w-10",
        'sm' => "h-8 w-8",
        'lg' => "h-16 w-16",
        'none' => "",
    }
@endphp

<div x-data="avatar()" {{$attributes->class(["$class $borderRadius aspect-square border flex justify-center items-center"])}}>
    @isset($image)
        <img
            x-bind="image"
            {{$image->attributes->class(["$borderRadius"])}}
        >
    @endisset
    @isset($fallback)
        <div
            x-show="loadError"
            x-bind="fallback"
            {{$fallback->attributes->class(['p-3'])}}
        >
            {{$fallback}}
        </div>
    @endisset
</div>
