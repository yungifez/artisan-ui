@props([
'side' => 'left',
'variant' => 'sidebar',
'collapsible' => "offcanvas",
'defaultOpen' => true,
'sidebar',
'side'
])
<div {{$attributes->twMerge(["group/sidebar-wrapper flex min-h-svh w-full has-data[attr=inset]:bg-sidebar"])}}
    >
    @isset($sidebar)
    <div {{$sidebar->attributes->except(['variant'])->twMerge([''])}}
        data-variant="{{$sidebar->attributes->get("variant")}}"></div>
    @endisset
    {{$slot}}
</div>
