<button type="button" data-sidebar="group-action" data-slot="sidebar-group-action" {{$attributes->twMerge(['absolute
    top-3.5 right-3 flex aspect-square w-5 items-center justify-center rounded-md p-0 text-sidebar-foreground
    ring-sidebar-ring outline-hidden transition-transform hover:bg-sidebar-accent hover:text-sidebar-accent-foreground
    focus-visible:ring-2 [&>svg]:size-4 [&>svg]:shrink-0 after:absolute after:-inset-2 md:after:hidden
    group-data-[collapsible=icon]:hidden'])}}>
    {{$slot}}
</button>
