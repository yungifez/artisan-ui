@props([
'active' => false,
'size' => 'default',
'tooltip' => null,
'expandSidebar' => true,
])

@php
$class = "peer/menu-button flex w-full items-center justify-start gap-2 overflow-hidden rounded-md p-2 text-left font-normal
ring-sidebar-ring
outline-hidden transition-[width,height,padding] group-has-data-[sidebar=menu-action]/menu-item:pr-8
group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-2! focus-visible:ring-2
group-data-[collapsible=icon]:justify-center group-data-[collapsible=icon]:[&>span]:hidden
disabled:pointer-events-none disabled:opacity-50 aria-disabled:pointer-events-none aria-disabled:opacity-50
data-[active=true]:bg-sidebar-accent data-[active=true]:font-medium data-[active=true]:text-sidebar-accent-foreground
data-[state=open]:hover:bg-sidebar-accent data-[state=open]:hover:text-sidebar-accent-foreground
[&>span:last-child]:truncate [&>svg]:size-4 [&>svg]:shrink-0 ";

$class .= match($attributes->get("variant")){
default => "hover:bg-sidebar-accent hover:text-sidebar-accent-foreground active:bg-sidebar-accent
active:text-sidebar-accent-foreground",
'outline' => "bg-background shadow-[0_0_0_1px_hsl(var(--sidebar-border))] hover:bg-sidebar-accent
hover:text-sidebar-accent-foreground hover:shadow-[0_0_0_1px_hsl(var(--sidebar-accent))]",
'none' => "",
};

$class .= " ".match($size){
default => "h-8 text-sm",
'sm' => "h-7 text-xs",
'lg' => "h-12 text-sm group-data-[collapsible=icon]:p-0!",
'none' => "",
};

$buttonAttributes = $attributes->except("variant")->twMerge([$class]);

if ($expandSidebar) {
    $buttonAttributes = $buttonAttributes->merge(['x-on:click' => 'sidebar.show()']);
}
@endphp

{{-- Opening the sidebar reads `sidebar.show()`, so the call cannot land in a
component the reader wrapped this button in. A submenu trigger opens the
sidebar and its own children on the same click. Pass `:expand-sidebar="false"`
for a button that must leave the sidebar alone. --}}
@if ($tooltip === null)
<april:button :attributes="$buttonAttributes" data-sidebar="menu-button" data-slot="sidebar-menu-button"
    data-size="{{$size}}" data-active="{{$active ? 'true' : 'false'}}" type="button" variant="none" size="none">
    {{$slot}}
</april:button>
@else
{{-- The label a reader needs while the sidebar shows icons only. The tooltip
stays silent for the rest of the time, because the button already says it. --}}
<april:tooltip class="w-full"
    x-effect="tooltipDisabled = sidebar.state !== 'collapsed' || sidebar.isMobile">
    <slot:trigger class="block w-full">
        <april:button :attributes="$buttonAttributes" data-sidebar="menu-button" data-slot="sidebar-menu-button"
            data-size="{{$size}}" data-active="{{$active ? 'true' : 'false'}}" type="button" variant="none" size="none">
            {{$slot}}
        </april:button>
    </slot:trigger>
    <slot:content>{{$tooltip}}</slot:content>
</april:tooltip>
@endif
