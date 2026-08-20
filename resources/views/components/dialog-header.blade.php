<div data-slot="dialog-header" {{$attributes->twMerge("flex flex-col space-y-1.5 text-center sm:text-left")}}>
    @isset($title)
    <h4 data-slot="dialog-title" x-bind="title" {{$title->attributes->twMerge(["text-lg font-semibold leading-none tracking-tight"])}}>{{$title}}
    </h4>
    @endisset
    @isset($description)
    <p data-slot="dialog-description" x-bind="description" {{$description->attributes->twMerge(["text-sm text-muted-foreground"])}}>
        {{$description}}
    </p>
    @endisset
</div>
