@props(
    [
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
    x-cloak
    {{$attributes->class(["$positionClass bg-background p-3 flex items-center fixed z-20 w-full h-autoduration-300 ease-out shadow-sm "])}}
>
    @isset($body)
        <div {{$body->attributes->class(["w-full h-full min-h-full px-3 mx-auto max-w-7xl "])}}>
            {{$body}}
        </div>
    @else
        <div class="w-full"></div>
    @endisset
    @if($attributes->has("dismissable"))
        <div @click="bannerVisible=false;">
        @isset($dismissTrigger)
           {{$dismissTrigger}}
        @else
            <x-aui::button
                variant="ghost"
                size="icon"
            >
                <x-aui::x class="fill-foreground"/>
            </x-aui::button>
        @endisset
        </div>
    @endif
</div>
