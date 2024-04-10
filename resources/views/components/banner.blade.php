@props(
    [
        'canDismiss' => false,
        'position' => 'top',
        'positionClass',
        "groupClass" => '',
        'transitionEnterStart' => '',
        'transitionEnterEnd' => '',
        'transitionLeaveStart' => '',
        'transitionLeaveEnd' => '',
        'bannerVisibleAfter' => 300,
        'dismissButtonClass' => ''
    ]
)

@php
    $positionClass = $positionClass ?? match($position){
        'top' => 'top-0 left-0 border-b',
        'bottom' => 'bottom-0 left-0 border-t',
        default => 'top-0 left-0 border-b',
    };
    $transitionEnterStart .= match($position){
        'top' => '-translate-y-10',
        'bottom' => 'translate-y-10',
        default => '-translate-y-10',
    };
    $transitionEnterEnd .= match($position){
        'top' => 'translate-y-0',
        'bottom' => 'translate-y-0',
        default => 'translate-y-0',
    };
    $transitionLeaveStart .= match($position){
        'top' => 'translate-y-0',
        'bottom' => 'translate-y-0',
        default => 'translate-y-0',
    };
    $transitionLeaveEnd .= match($position){
        'top' => '-translate-y-10',
        'bottom' => 'translate-y-10',
        default => '-translate-y-10',
    };
@endphp

<div
    x-data="{
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
    class="{{$groupClass}} {{$positionClass}} flex items-center fixed z-20 w-full h-auto py-2 duration-300 ease-out shadow-sm sm:py-0 "
    x-cloak
    {{$attributes->whereStartsWith("group")}}
>
    <div class="w-full h-full min-h-full px-3 mx-auto max-w-7xl "
        {{$attributes->whereDoesntStartWith(["group", "dismissButton"])}}>
        {{$slot}}
    </div>
    @if($canDismiss)
        <button
            @click="bannerVisible=false;"
            class="{{$dismissButtonClass}} flex mx-4 items-center flex-shrink-0 translate-x-1 ease-out duration-150 justify-center w-6 h-6 p-1.5 rounded-full"
            {{$attributes->whereStartsWith("dismissButton")}}
        >
            <x-aui::x class=""/>
        </button>
    @endif
</div>
