@props([
'defaultOpen' => true,
'width' => null,
'widthIcon' => null,
])

{{-- Holds the sidebar state. Put the sidebar and the page content in the slot. --}}
<div x-data="sidebar(@js($defaultOpen))" x-modelable="open" x-bind="root" data-slot="sidebar-wrapper" @if ($width || $widthIcon)
    @style([
    "--sidebar-width: $width" => $width,
    "--sidebar-width-icon: $widthIcon" => $widthIcon,
    ])
    @endif {{$attributes->twMerge(['group/sidebar-wrapper flex h-full min-h-svh w-full
    has-data-[variant=inset]:bg-sidebar'])}}>
    {{$slot}}
</div>
