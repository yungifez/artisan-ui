@props(['open' => false, 'disabled' => false])

<div data-slot="collapsible" data-state="closed"
    x-data="collapsible(@js($open), @js($disabled))" x-bind="root" x-modelable="open"
    {{$attributes->twMerge(['w-full'])}}>
    @isset($trigger)
    <div data-slot="collapsible-trigger" x-bind="trigger" {{$trigger->attributes}}>
        {{$trigger}}
    </div>
    @endisset
    @isset($content)
    <div data-slot="collapsible-content" x-bind="content" x-cloak {{$content->attributes}}>
        {{$content}}
    </div>
    @endisset
</div>
