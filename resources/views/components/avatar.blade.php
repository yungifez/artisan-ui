@props(['class' => '', 'size' => 'w-10 h-10', 'src' => '', 'fallback' => ''])

<div x-data="{loadError: false}" class="{{$size}} aspect-square rounded-full border flex justify-center items-center">
    <img
        class="{{$class}} rounded-full"
        {{$attributes}}
        x-show="!loadError"
        x-on:error="loadError = true"
        src="{{$src}}"

    >
    <div
        x-show="loadError"
        class="{{$class}} p-3"
        {{$attributes}}
    >
        {{$fallback}}
    </div>
</div>
