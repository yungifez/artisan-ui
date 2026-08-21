<button type="button" data-slot="context-menu-item" role="menuitem" x-bind="menuItem"
    {{$attributes->twMerge(['relative flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground disabled:pointer-events-none disabled:opacity-50'])}}>
    {{$slot}}
</button>
