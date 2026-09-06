@props(['level' => 2])

@php($titleLevel = aprilHeadingLevel($level))

<div data-slot="sheet-header" {{$attributes->twMerge("flex flex-col space-y-2 text-center sm:text-left")}}>
    @isset($title)
    <h{{$titleLevel}} data-slot="sheet-title" x-bind="title" {{$title->attributes->twMerge(["text-lg font-semibold text-foreground"])}}>{{$title}}</h{{$titleLevel}}>
    @endisset
    @isset($description)
    <p data-slot="sheet-description" x-bind="description" {{$description->attributes->twMerge(["text-sm text-muted-foreground"])}}>
        {{$description}}
    </p>
    @endisset
</div>
