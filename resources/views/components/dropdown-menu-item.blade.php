<div data-slot="dropdown-menu-item">
    <april:button tabindex="-1" :attributes="$attributes->twMerge(['relative justify-start flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm
        outline-none transition-colors focus:bg-accent focus:text-accent-foreground w-full'])" role="menuitem"
        size="none" x-bind="menuItem" variant="ghost">
        {{$slot}}
    </april:button>
</div>
