@props(['title', 'description', "footer", "body"])

<div {{$attributes->twMerge(["rounded-lg border bg-card text-card-foreground shadow-sm"])}}>
    <div class="{{$attributes->get('header-class')}} flex flex-col space-y-1.5 p-6" {{$attributes->
        whereStartsWith('header')}}>
        @isset($title)
        <h3 {{$title->attributes->twMerge(["font-semibold text-2xl leading-none tracking-tight"])}}>{{$title}}</h3>
        @endisset
        @isset($description)
        <p {{$description->attributes->twMerge(["text-sm text-muted-foreground"])}}>{{$description}}</p>
        @endisset
    </div>
    @isset($content)
    <div {{$content->attributes->twMerge(["p-6 pt-0"])}}>
        {{$content}}
    </div>
    @endisset
    @isset($footer)
    <div {{$footer->attributes->twMerge(["flex items-center p-6 pt-0"])}} >
        {{$footer}}
    </div>
    @endisset
</div>
