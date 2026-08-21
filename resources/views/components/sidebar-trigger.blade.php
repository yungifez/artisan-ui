<april:button :attributes='$attributes->twMerge(["size-7 flex items-center justify-center"])' data-sidebar="trigger"
    data-slot="sidebar-trigger" variant="ghost" size="icon" type="button" title="Toggle Sidebar" x-on:click="toggle()">
    @if (trim((string) $slot) !== '')
    {{$slot}}
    @else
    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <rect width="18" height="18" x="3" y="3" rx="2" />
        <path d="M9 3v18" />
    </svg>
    @endif
    <span class="sr-only">Toggle Sidebar</span>
</april:button>
