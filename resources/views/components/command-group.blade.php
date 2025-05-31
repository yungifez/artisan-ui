@props(['heading' => ''])
<div x-bind="commandGroupContainer" role="presentation" cmd-groups {{$attributes->twMerge(['overflow-hidden p-1
    text-foreground' ])}}
    >
    <p class="py-1.5 text-xs font-medium text-muted-foreground px-2" aria-hidden="true" x-bind="commandGroupHeading"
        cmd-group-headings>
        {{$heading}}</p>
    <div role="group" x-bind="commandGroup" cmd-group-items>
        {{$slot}}
    </div>
</div>
