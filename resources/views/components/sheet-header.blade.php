<div {{$attributes->class("flex flex-col space-y-2 text-center sm:text-left")}}>
    @isset($title)
    <h4 x-bind="title" {{$title->attributes->class(["text-lg font-semibold text-foreground"])}}>{{$title}}</h4>
    @endisset
    @isset($description)
    <p x-bind="description" {{$description->attributes->class(["text-sm text-muted-foreground"])}}>
        {{$description}}
    </p>
    @endisset
</div>
