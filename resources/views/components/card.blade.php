@props(['title', 'description', "footer", "body"])

<div {{$attributes->class(["rounded-lg border bg-card text-card-foreground shadow-sm"])}}>
    <div class="{{$attributes->get('header-class')}} flex flex-col space-y-1.5 p-6" {{$attributes->
        whereStartsWith('header')}}>
        @isset($title)
        <h3 {{$title->attributes->class(["font-semibold text-2xl leading-none tracking-tight"])}}>{{$title}}</h3>
        @endisset
        @isset($description)
        <p {{$description->attributes->class(["text-sm text-muted-foreground"])}}>{{$description}}</p>
        @endisset
    </div>
    @isset($content)
    <div {{$content->attributes->class(["p-6 pt-0"])}}>
        {{$content}}
    </div>
    @endisset
    @isset($footer)
    <div {{$footer->attributes->class(["flex items-center p-6 pt-0"])}} >
        {{$footer}}
    </div>
    @endisset
</div>
