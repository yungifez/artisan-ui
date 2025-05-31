<div {{$attributes->twMerge("flex flex-col space-y-1.5 text-center sm:text-left")}}>
    @isset($title)
    <h4 x-bind="title" {{$title->attributes->twMerge(["text-lg font-semibold leading-none tracking-tight"])}}>{{$title}}
    </h4>
    @endisset
    @isset($description)
    <p x-bind="description" {{$description->attributes->twMerge(["text-sm text-muted-foreground"])}}>
        {{$description}}
    </p>
    @endisset
</div>
