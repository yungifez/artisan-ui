<div data-slot="alert-dialog-header" {{$attributes->twMerge(['flex flex-col space-y-2 text-center sm:text-left'])}}>
    @isset($media)
    <div data-slot="alert-dialog-media" {{$media->attributes->twMerge(['mx-auto flex size-10 items-center justify-center rounded-full bg-muted sm:mx-0'])}}>
        {{$media}}
    </div>
    @endisset
    @isset($title)
    <h2 data-slot="alert-dialog-title" x-bind="title"
        {{$title->attributes->twMerge(['text-lg font-semibold'])}}>{{$title}}</h2>
    @endisset
    @isset($description)
    <p data-slot="alert-dialog-description" x-bind="description"
        {{$description->attributes->twMerge(['text-sm text-muted-foreground'])}}>{{$description}}</p>
    @endisset
</div>
