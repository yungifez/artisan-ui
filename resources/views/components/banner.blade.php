@props(['color' => 'bg-white dark:bg-black dark:text-white dark:border-gray-500', 'canDismiss' => false, 'position' => 'top', 'positionClass', 'transitionEnterStart' => '', 'transitionEnterEnd' => '', 'transitionLeaveStart' => '', 'transitionLeaveEnd' => '', 'bannerVisibleAfter' => 300])

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
    class="{{$color}} {{$positionClass}} fixed z-10 w-full h-auto py-2 duration-300 ease-out shadow-sm sm:py-0 " x-cloak>
    <div class="flex items-center justify-between w-full h-full min-h-full px-3 mx-auto max-w-7xl ">
        {{$slot}}
        @if($canDismiss)
            <button @click="bannerVisible=false; setTimeout(()=>{ bannerVisible = true }, 1000);" class="flex items-center flex-shrink-0 translate-x-1 ease-out duration-150 justify-center w-6 h-6 p-1.5 text-black rounded-full hover:bg-neutral-100">
                <x-artisan-ui::x/>
            </button>
        @endif
    </div>
</div>
