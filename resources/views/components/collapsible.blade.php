@props(['open' => false, 'disabled' => false])

<div data-slot="collapsible" data-state="closed"
    x-data="collapsible(@json($open), @json($disabled))" x-bind="root"
    {{$attributes}}>
    @isset($trigger)
    <div data-slot="collapsible-trigger" x-bind="trigger" {{$trigger->attributes}}>
        {{$trigger}}
    </div>
    @endisset
    @isset($content)
    <div data-slot="collapsible-content" x-bind="content" {{$content->attributes}}>
        {{$content}}
    </div>
    @endisset
</div>
