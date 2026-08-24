@props([
'side' => 'left',
'variant' => 'sidebar',
'collapsible' => 'offcanvas',
'defaultOpen' => true,
])

@php
$gapClass = match($variant) {
'floating', 'inset' => 'group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+1rem)]',
default => 'group-data-[collapsible=icon]:w-[var(--sidebar-width-icon)]',
};

$containerClass = match($side) {
'right' => 'right-0 group-data-[collapsible=offcanvas]:right-[calc(var(--sidebar-width)*-1)]',
default => 'left-0 group-data-[collapsible=offcanvas]:left-[calc(var(--sidebar-width)*-1)]',
};

$containerClass .= ' '.match($variant) {
'floating', 'inset' => 'p-2 group-data-[collapsible=icon]:w-[calc(var(--sidebar-width-icon)+1rem+2px)]',
default => 'group-data-[collapsible=icon]:w-[var(--sidebar-width-icon)] group-data-[side=left]:border-r
group-data-[side=right]:border-l',
};

$mobileClass = match($side) {
'right' => 'right-0 border-l',
default => 'left-0 border-r',
};

$offscreen = match($side) {
'right' => 'translate-x-full',
default => '-translate-x-full',
};

$sections = view('april::partials.sidebar-sections', [
'header' => $header ?? null,
'content' => $content ?? null,
'footer' => $footer ?? null,
])->render();

$persist = $attributes->get('x-persist');

$attributes = $attributes->except('x-persist');
@endphp

@if ($collapsible === 'none')
<div data-slot="sidebar" @if ($persist) x-persist="{{ $persist }}" @endif {{ $attributes->twMerge([
    'flex min-h-0 self-stretch w-[var(--sidebar-width)] flex-col overflow-hidden bg-sidebar text-sidebar-foreground'
    ]) }}
    >
    {!! $sections !!}
    {{ $slot }}
</div>
@else
<div class="group peer hidden text-sidebar-foreground md:block relative min-h-0 self-stretch shrink-0"
    data-slot="sidebar" data-side="{{ $side }}" data-variant="{{ $variant }}"
    data-state="{{ $defaultOpen ? 'expanded' : 'collapsed' }}" data-collapsible="{{ $defaultOpen ? '' : $collapsible }}"
    :data-state="state" :data-collapsible="open ? '' : '{{ $collapsible }}'" @if ($persist)
    x-persist="{{ $persist }}-desktop" @endif>
    <div data-slot="sidebar-gap" class="relative h-full w-[var(--sidebar-width)] shrink-0 bg-transparent transition-[width]
                duration-200 ease-linear group-data-[collapsible=offcanvas]:w-0
                group-data-[side=right]:rotate-180 {{ $gapClass }}"></div>

    <div data-slot="sidebar-container" class="absolute inset-y-0 z-10 hidden h-full w-[var(--sidebar-width)]
                transition-[left,right,width] duration-200 ease-linear md:flex {{ $containerClass }}">
        <div data-sidebar="sidebar" data-slot="sidebar-inner" {{ $attributes->twMerge([
            'flex h-full min-h-0 w-full flex-col overflow-hidden bg-sidebar
            group-data-[variant=floating]:rounded-lg
            group-data-[variant=floating]:border
            group-data-[variant=floating]:border-sidebar-border
            group-data-[variant=floating]:shadow-sm'
            ]) }}
            >
            {!! $sections !!}
            {{ $slot }}
        </div>
    </div>
</div>

<div class="md:hidden" x-cloak>
    <div x-show="openMobile" x-transition.opacity x-on:click="close()" class="fixed inset-0 z-40 bg-black/80"></div>

    <div x-show="openMobile" x-cloak x-on:keydown.esc.window="close()" data-sidebar="sidebar" data-slot="sidebar"
        data-mobile="true" data-side="{{ $side }}" x-transition:enter="transition ease-in-out duration-300"
        x-transition:enter-start="{{ $offscreen }}" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="{{ $offscreen }}" class="fixed inset-y-0 z-50 flex h-svh
                w-[var(--sidebar-width-mobile)] flex-col overflow-hidden
                bg-sidebar p-0 text-sidebar-foreground {{ $mobileClass }}">
        <span class="sr-only">Sidebar</span>

        {!! $sections !!}
        {{ $slot }}
    </div>
</div>
@endif
