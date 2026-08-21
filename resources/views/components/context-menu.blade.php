<div data-slot="context-menu" data-state="closed" x-data="contextMenu" x-bind="root">
    <div data-slot="context-menu-trigger" x-bind="trigger">
        {{$slot}}
    </div>
    @isset($content)
    <div data-slot="context-menu-content" x-bind="content" x-ref="content" role="menu"
        {{$content->attributes->twMerge(['fixed z-50 min-w-32 rounded-md border bg-popover p-1 text-popover-foreground shadow-md'])}}>
        {{$content}}
    </div>
    @endisset
</div>
