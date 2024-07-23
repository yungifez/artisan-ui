<div {{$attributes->class("flex flex-col space-y-2 text-center sm:text-left")}}>
    @isset($title)
    <h4 {{$title->attributes->class(["text-lg font-semibold text-foreground"])}}>{{$title}}</h4>
    @endisset
    @isset($description)
    <p {{$description->attributes->class(["text-sm text-muted-foreground"])}}>
        {{$description}}
    </p>
    @endisset
</div>
