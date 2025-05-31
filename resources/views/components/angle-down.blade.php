@props(["class" => ''])

@php
$class .= " ".match($attributes->get("size")){
default => "h-3 w-3",
'lg' => "w-5 h-5",
'none' => "",
}
@endphp
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" {{$attributes->twMerge(["$class"])}} version="1.1">
    <path d="M903.232 256l56.768 50.432L512 768 64 306.432 120.768 256 512 659.072z" />
</svg>
