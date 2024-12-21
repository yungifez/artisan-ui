@props(['heading' => ''])
<div x-bind="commandGroupContainer" role="presentation" {{$attributes->class(['overflow-hidden p-1 text-foreground' ])}}
    >
    <p class="py-1.5 text-xs font-medium text-muted-foreground px-2" aria-hidden="true" x-bind="commandGroupHeading">
        {{$heading}}</p>
    <div role="group" x-bind="commandGroup">
        {{$slot}}
    </div>
</div>
