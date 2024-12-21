@props(['heading' => ''])
<div x-bind="commandGroup" {{$attributes->class(['overflow-hidden p-1 text-foreground' ])}} >
    <p class="py-1.5 text-xs font-medium text-muted-foreground px-2">{{$heading}}</p>
    {{$slot}}
</div>
