@props(['color' => 'bg-[color:var(--banner-bg-color)] dark:bg-[color:var(--banner-dark-bg-color)] text-[var(--banner-text-color)] dark:text-[var(--banner-dark-text-color)] border-[color:var(--banner-border-color)] dark:border-[color:var(--banner-dark-border-color)] ', 'canDismiss' => false, 'position' => 'top', 'positionClass', 'transitionEnterStart' => '', 'transitionEnterEnd' => '', 'transitionLeaveStart' => '', 'transitionLeaveEnd' => '', 'bannerVisibleAfter' => 300])

@php
    $positionClass = $positionClass ?? match($position){
        'top' => 'top-0 left-0 border-b',
        'bottom' => 'bottom-0 left-0 border-t',
        default => 'top-0 left-0'
    };
    $transitionEnterStart .= match($position){
        'top' => '-translate-y-10',
        'bottom' => 'translate-y-10',
    };
    $transitionEnterEnd .= match($position){
        'top' => 'translate-y-0',
        'bottom' => 'translate-y-0',
    };
    $transitionLeaveStart .= match($position){
        'top' => 'translate-y-0',
        'bottom' => 'translate-y-0',
    };
    $transitionLeaveEnd .= match($position){
        'top' => '-translate-y-10',
        'bottom' => 'translate-y-10',
    };
@endphp
<div x-data="{
        bannerVisible: false,
        bannerVisibleAfter: {{$bannerVisibleAfter}},
    }"
    x-show="bannerVisible"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="{{$transitionEnterStart}}"
    x-transition:enter-end="{{$transitionEnterEnd}}"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="{{$transitionLeaveStart}}"
    x-transition:leave-end="{{$transitionLeaveEnd}}"
    x-init="
        setTimeout(()=>{ bannerVisible = true }, bannerVisibleAfter);
    "
    class="{{$color}} {{$positionClass}} flex items-center fixed z-10 w-full h-auto py-2 duration-300 ease-out shadow-sm sm:py-0 " x-cloak>
    <div class="w-full h-full min-h-full px-3 mx-auto max-w-7xl ">
        {{$slot}}
    </div>
    @if($canDismiss)
    <button @click="bannerVisible=false;" class="flex mx-4 items-center flex-shrink-0 translate-x-1 ease-out duration-150 justify-center w-6 h-6 p-1.5 rounded-full">
        <x-aui::x class=""/>
    </button>
    @endif
</div>
