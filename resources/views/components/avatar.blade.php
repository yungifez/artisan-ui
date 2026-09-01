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

<div data-slot="avatar" x-data="avatar()" {{$attributes->twMerge(["$class $borderRadius aspect-square shrink-0 min-w-0 overflow-hidden border flex justify-center
    items-center"])}}>
    @isset($image)
    <img data-slot="avatar-image" x-bind="image" {{$image->attributes->twMerge(["$borderRadius size-full object-cover"])}}
    >
    @endisset
    @isset($fallback)
    <div data-slot="avatar-fallback" x-bind="fallback" {{$fallback->attributes->twMerge(['p-3'])}}
        >
        {{$fallback}}
    </div>
    @endisset
</div>
