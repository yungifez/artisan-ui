@props(['trigger', 'content'])
<div x-data="dropdownMenu" x-bind="root">
    @isset($trigger)
    <div {{$trigger->attributes->twMerge(['w-fit inline-block'])}} x-bind="trigger" x-ref="trigger"
        aria-haspopup="true">
        {{$trigger}}
    </div>
    @endisset
    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        @isset($content)
        <div x-bind="content" x-ref="content" x-cloak role="menu" aria-orientation="horizontal" {{$content->
            attributes->twMerge(["z-50
            min-w-[8rem] rounded-md border
            bg-popover p-1
            text-popover-foreground shadow-lg"])}}
            >
            {{$content}}
        </div>
        @if ($attributes->has('x-teleport'))
    </template>
    @endif
    @endisset
</div>
