@props([
'durationDelay' => '100'
])
<div x-data="tooltip({{durationDelay}})">
    <div x-bind="trigger" class="w-fit inline-block" x-ref="trigger">
        @isset($tooltipTrigger)
        {{$tooltipTrigger}}
        @endisset
    </div>
    @isset($tooltipContent)
    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        <div x-cloak x-bind="content" {{$tooltipContent->attributes->class(["z-50 w-72 rounded-md border bg-tooltip p-4
            text-tooltip-foreground shadow-md outline-none"])}}>
            {{$tooltipContent}}
        </div>
        @if ($attributes->has('x-teleport'))
    </template>
    @endif
    @endisset
</div>
