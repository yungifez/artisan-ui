<div x-data="accordionItem()" x-bind="root" {{ $attributes->class(["w-full border-b"]) }}>
    @isset($trigger)
    <h3>
        <button {{$trigger->attributes->class(['flex flex-1 items-center justify-between px-2 py-4 font-medium
            transition-all
            hover:underline w-full'])}}
            x-bind="trigger">
            {{$trigger}}
            <span @isset($icon) {{$icon->attributes}} @endisset>
                @isset($icon)
                {{$icon}}
                @else
                <x-aui::angle-down class=" transition-transform duration-200 fill-foreground" x-bind="icon" />
                @endisset
            </span>
        </button>
        @endisset
    </h3>
    @isset($content)
    <div x-bind="content" class="overflow-hidden text-sm" role="region">
        <div {{$content->attributes->class(['pb-4 pt-0 px-2'])}}>
            {{$content}}
        </div>
    </div>
    @endisset
</div>
