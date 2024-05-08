<div x-data="popover">
    <div x-bind="trigger" class="w-fit inline-block" x-ref="trigger">
        @isset($popoverTrigger)
        {{$popoverTrigger}}
        @else
        <x-aui::button variant="outline" type="button">Open</x-aui::button>
        @endisset
    </div>
    @isset($popoverContent)
    <div x-bind="content" {{$popoverContent->attributes->class(["z-50 w-72 rounded-md border bg-popover p-4
        text-popover-foreground shadow-md outline-none"])}}>
        {{$popoverContent}}
    </div>
    @endisset
</div>
