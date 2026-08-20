@props([
'defaultValue' => '',
'activationMode' => 'automatic',
])

<div data-slot="tabs" x-data="tabs('{{$defaultValue}}', '{{$activationMode}}')" {{$attributes}}>
    @isset($tabsList)
    <div data-slot="tabs-list" role="tablist" {{$tabsList->attributes->twMerge(['inline-flex h-10 items-center justify-center rounded-md
        bg-muted p-1
        text-muted-foreground'])}} x-bind="tabsList">
        {{$tabsList}}
    </div>
    @endisset
    {{$slot}}
</div>
