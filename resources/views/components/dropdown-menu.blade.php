<div x-data="dropdownMenu">
    <div class="w-fit inline-block" x-bind="trigger" x-ref="trigger">
        @isset($dropdownMenuTrigger)
        {{$dropdownMenuTrigger}}
        @else
        <x-aui::button variant="outline" type="button">Open</x-aui::button>
        @endisset
    </div>
    @isset($dropdownMenuContent)
    <div x-bind="content" {{$dropdownMenuContent->attributes->class(["z-50 min-w-[8rem] rounded-md border bg-popover p-1
        text-popover-foreground shadow-lg"])}}
        >
        {{$dropdownMenuContent}}
    </div>
    @endisset
</div>
