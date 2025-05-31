@props([
'delayDuration' => 50,
'skipDelayDuration' => 100,
'defaultOpen' => false,
'trigger',
'content'
])
<div x-data="tooltip({{$delayDuration}}, {{$skipDelayDuration}}, @js($defaultOpen))" {{$attributes->
    twMerge(['w-fit'])}}>
    @isset($trigger)
    <div x-bind="trigger" x-ref="trigger" {{$trigger->attributes->twMerge('w-fit inline-block')}}>
        {{$trigger}}
    </div>
    @endisset
    @isset($content)
    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        <div x-cloak x-ref="content" x-bind="content" {{$content->attributes->twMerge(["z-50 overflow-hidden rounded-md
            bg-primary px-3
            py-1.5 text-xs text-primary-foreground"])}}>
            {{$content}}
        </div>
        <svg x-bind="svg" height="15" width="15" viewBox="0 0 100 100">
            <polygon points="50,75 90,25 10,25" fill="white" />
        </svg>
        @if ($attributes->has('x-teleport'))
    </template>
    @endif
    @endisset
</div>
