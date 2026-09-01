<div data-slot="accordion-item" data-state="closed" x-data="accordionItem()" x-bind="root" {{ $attributes->twMerge(["w-full border-b"]) }}>
    @isset($trigger)
    <h3>
        <button type="button" data-slot="accordion-trigger" data-state="closed" {{$trigger->attributes->twMerge(['flex flex-1 text-left items-center justify-between px-2 py-4
            font-medium
            transition-all
            hover:underline w-full'])}}
            x-bind="trigger">
            {{$trigger}}
            <span @isset($icon) {{$icon->attributes}} @endisset>
                @isset($icon)
                {{$icon}}
                @else
                <april:angle-down class=" transition-transform duration-200 fill-foreground" x-bind="icon" />
                @endisset
            </span>
        </button>
        @endisset
    </h3>
    @isset($content)
    <div data-slot="accordion-content" data-state="closed" x-bind="content" class="overflow-hidden text-sm" role="region" x-cloak>
        <div {{$content->attributes->twMerge(['pb-4 pt-0 px-2'])}}>
            {{$content}}
        </div>
    </div>
    @endisset
</div>
