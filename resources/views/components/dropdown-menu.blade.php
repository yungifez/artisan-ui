<div x-data="dropdownMenu">
    <div class="w-fit inline-block" x-bind="trigger" x-ref="trigger">
        @isset($trigger)
        {{$trigger}}
        @else
        <x-aui::button variant="outline" type="button">Open</x-aui::button>
        @endisset
    </div>
    @isset($dropdownMenuContent)
    <div x-bind="content" x-cloak {{$content->attributes->class(["z-50 min-w-[8rem] rounded-md border
        bg-popover p-1
        text-popover-foreground shadow-lg"])}}
        >
        {{$content}}
    </div>
    @endisset
</div>
