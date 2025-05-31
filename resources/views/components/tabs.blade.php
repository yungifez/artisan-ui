<div x-data="tabs('{{$attributes->get('defaultValue')}}', '{{$attributes->get('activationMode')}}')" {{$attributes}}>
    @isset($tabsList)
    <div role="tablist" {{$tabsList->attributes->twMerge(['inline-flex h-10 items-center justify-center rounded-md
        bg-muted p-1
        text-muted-foreground'])}} x-bind="tabsList">
        {{$tabsList}}
    </div>
    @endisset
    {{$slot}}
</div>
