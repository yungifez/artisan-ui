@props([
'delayDuration' => 50,
'skipDelayDuration' => 100,
'defaultOpen' => false,
'trigger',
'content',
'svg'
])
<div x-data="tooltip({{$delayDuration}}, {{$skipDelayDuration}}, @js($defaultOpen))" {{$attributes->
    whereDoesntStartWith('x-teleport')->twMerge(['w-fit'])}}>
    @isset($trigger)
    <div x-bind="trigger" x-ref="trigger" {{$trigger->attributes->twMerge('w-fit inline-block')}}>
        {{$trigger}}
    </div>
    @endisset
    @isset($content)
    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        <div>
            <div x-cloak x-ref="content" x-bind="content" {{$content->attributes->twMerge(["z-50 overflow-hidden
                rounded-md
                bg-primary px-3
                py-1.5 text-xs text-primary-foreground"])}}>
                {{$content}}
            </div>

            <div x-bind="svg" @isset($svg) {{$svg->attributes->twMerge(["z-50"])}}
                @else class="z-50" @endisset>
                @isset($svg)
                {{$svg}}
                @else
                <svg class="fill-primary" height="15" width="15" viewBox="0 0 100 100">
                    <polygon points="50,75 90,25 10,25" />
                </svg>
                @endisset
            </div>
        </div>
        @if ($attributes->has('x-teleport'))
    </template>
    @endif
    @endisset
</div>
