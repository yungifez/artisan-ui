@props(['trigger', 'content'])
<div x-data="dropdownMenu" x-bind="root">
    @isset($trigger)
    <div {{$trigger->attributes->class(['w-fit inline-block'])}} x-bind="trigger" x-ref="trigger">
        {{$trigger}}
    </div>
    @endisset
    @isset($content)
    <div x-bind="content" x-cloak {{$content->attributes->class(["z-50 min-w-[8rem] rounded-md border
        bg-popover p-1
        text-popover-foreground shadow-lg"])}}
        >
        {{$content}}
    </div>
    @endisset
</div>
