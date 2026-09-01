<div data-slot="dropdown-menu" data-state="closed" x-data="dropdownMenu" x-bind="root" {{$attributes->except('x-teleport')}}>
    @isset($trigger)
    <div data-slot="dropdown-menu-trigger" {{$trigger->attributes->twMerge(['w-fit inline-block'])}} x-bind="trigger" x-ref="trigger"
        aria-haspopup="menu">
        {{$trigger}}
    </div>
    @endisset
    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        @isset($content)
        <div data-slot="dropdown-menu-content" x-bind="content" x-ref="content" x-cloak role="menu" aria-orientation="vertical" {{$content->
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
