{{-- The page content that sits next to the sidebar. --}}
<main data-slot="sidebar-inset" {{$attributes->twMerge(['relative flex w-full flex-1 flex-col bg-background
    md:peer-data-[variant=inset]:m-2 md:peer-data-[variant=inset]:ml-0 md:peer-data-[variant=inset]:rounded-xl
    md:peer-data-[variant=inset]:shadow-sm md:peer-data-[variant=inset]:peer-data-[state=collapsed]:ml-2'])}}>
    {{$slot}}
</main>
