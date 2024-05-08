<div
    x-data="accordionItem()"
    x-bind="root"
    {{ $attributes->class(["w-full scroll-smooth py-3 px-4"])}}
>
    <button class="w-full" x-bind="trigger">
        <div class="my-1 font-semibold flex items-center justify-between w-full">
            @isset($title)
                <div {{$title->attributes->class(['text-left select-none hover:underline'])}}>
                        {{$title}}
                </div>
            @endisset
            <div @isset($icon) {{$icon->attributes}} @endisset>
                @isset($icon)
                   {{$icon}}
                @else
                    <x-aui::angle-down class="w-2 transition text-center fill-foreground" x-bind="icon"/>
                @endisset
            </div>
        </div>
    </button>
    @isset($content)
        <div
            x-bind="content"
            {{$content->attributes}}
        >
            {{$content}}
        </div>
    @endisset
</div>
