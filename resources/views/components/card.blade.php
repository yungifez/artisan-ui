@props(['level' => 2])

@php
$rootAttributes = $attributes->whereDoesntStartWith('header');
$titleLevel = aprilHeadingLevel($level);
@endphp

<div data-slot="card" {{$rootAttributes->twMerge(["rounded-lg border bg-card text-card-foreground shadow-sm"])}}>
    <div data-slot="card-header" class="{{$attributes->get('header-class')}} flex flex-col space-y-1.5 p-6" {{$attributes->
        whereStartsWith('header')}}>
        @isset($title)
        <h{{$titleLevel}} data-slot="card-title" {{$title->attributes->twMerge(["font-semibold text-2xl leading-none tracking-tight"])}}>{{$title}}</h{{$titleLevel}}>
        @endisset
        @isset($description)
        <p data-slot="card-description" {{$description->attributes->twMerge(["text-sm text-muted-foreground"])}}>{{$description}}</p>
        @endisset
    </div>
    @isset($content)
    <div data-slot="card-content" {{$content->attributes->twMerge(["p-6 pt-0"])}}>
        {{$content}}
    </div>
    @endisset
    @isset($footer)
    <div data-slot="card-footer" {{$footer->attributes->twMerge(["flex items-center p-6 pt-0"])}} >
        {{$footer}}
    </div>
    @endisset
</div>
