<div data-sidebar="menu-badge" data-slot="sidebar-menu-badge" {{$attributes->twMerge(['pointer-events-none absolute
    right-1 flex h-5 min-w-5 items-center justify-center rounded-md px-1 text-xs font-medium text-sidebar-foreground
    tabular-nums select-none peer-hover/menu-button:text-sidebar-accent-foreground
    peer-data-[active=true]/menu-button:text-sidebar-accent-foreground peer-data-[size=sm]/menu-button:top-1
    peer-data-[size=default]/menu-button:top-1.5 peer-data-[size=lg]/menu-button:top-2.5
    group-data-[collapsible=icon]:hidden'])}}>
    {{$slot}}
</div>
