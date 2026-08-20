@props([
'showIcon' => false,
])

@php
// Give each row a different width so a list of them does not look like a grid.
$width = random_int(50, 90);
@endphp

<div data-sidebar="menu-skeleton" data-slot="sidebar-menu-skeleton" {{$attributes->twMerge(['flex h-8 items-center
    gap-2 rounded-md px-2'])}}>
    @if ($showIcon)
    <april:skeleton class="size-4 rounded-md" data-sidebar="menu-skeleton-icon" />
    @endif
    <april:skeleton class="h-4 flex-1" data-sidebar="menu-skeleton-text" style="max-width: {{$width}}%" />
</div>
