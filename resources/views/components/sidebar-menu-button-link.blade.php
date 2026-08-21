@props([
'active' => false,
'size' => 'default',
])

@php
$class = "peer/menu-button flex justify-start w-full items-center gap-2 overflow-hidden rounded-md p-2 text-left
font-normal
ring-sidebar-ring
outline-hidden transition-[width,height,padding] group-has-data-[sidebar=menu-action]/menu-item:pr-8
group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:p-2! focus-visible:ring-2
group-data-[collapsible=icon]:justify-center group-data-[collapsible=icon]:[&>span]:hidden
aria-disabled:pointer-events-none aria-disabled:opacity-50 data-[active=true]:bg-sidebar-accent
data-[active=true]:font-medium data-[active=true]:text-sidebar-accent-foreground
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
@endphp

{{-- The anchor form of april:sidebar-menu-button. Use it for a link. --}}
<april:button-link :attributes='$attributes->except("variant")->twMerge([$class])' data-sidebar="menu-button"
    data-slot="sidebar-menu-button" data-size="{{$size}}" data-active="{{$active ? 'true' : 'false'}}"
    :aria-current="$active ? 'page' : null" variant="none" size="none">
    {{$slot}}
</april:button-link>
