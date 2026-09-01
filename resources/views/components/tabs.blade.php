@props([
'defaultValue' => '',
'activationMode' => 'automatic',
])

@php($list = $list ?? $tabsList ?? null)

<div data-slot="tabs" x-data="tabs('{{$defaultValue}}', '{{$activationMode}}')" {{$attributes}}>
    @isset($list)
    <div data-slot="tabs-list" role="tablist" {{$list->attributes->twMerge(['inline-flex h-10 items-center justify-center rounded-md
        bg-muted p-1
        text-muted-foreground'])}} x-bind="tabsList">
        {{$list}}
    </div>
    @endisset
    {{$slot}}
</div>
