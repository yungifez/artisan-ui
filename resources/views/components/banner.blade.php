@props(
[
'position' => 'top',
'positionClass',
'transitionEnterStart' => '',
'transitionEnterEnd' => '',
'transitionLeaveStart' => '',
'transitionLeaveEnd' => '',
'displayAfter' => 500,
]
)

@php
$positionClass = $positionClass ?? match($position){
'top' => 'top-0 left-0 border-b',
'bottom' => 'bottom-0 left-0 border-t',
default => 'top-0 left-0 border-b',
'none' => '',
};
$transitionEnterStart .= match($position){
'top' => '-translate-y-10',
'bottom' => 'translate-y-10',
default => '-translate-y-10',
'none' => '',
};
$transitionEnterEnd .= match($position){
'top' => 'translate-y-0',
'bottom' => 'translate-y-0',
default => 'translate-y-0',
'none' => '',
};
$transitionLeaveStart .= match($position){
'top' => 'translate-y-0',
'bottom' => 'translate-y-0',
default => 'translate-y-0',
'none' => '',
};
$transitionLeaveEnd .= match($position){
'top' => '-translate-y-10',
'bottom' => 'translate-y-10',
default => '-translate-y-10',
'none' => '',
};
@endphp

<div x-data="banner({{$displayAfter}},'{{$transitionEnterStart}}','{{$transitionEnterEnd}}','{{$transitionLeaveStart}}','{{$transitionLeaveEnd}}')"
    x-bind="root" {{$attributes->twMerge(["$positionClass bg-background p-3 flex items-center fixed z-20 w-full
    h-autoduration-300 ease-out shadow-sm "])}}
    >
    @isset($body)
    <div {{$body->attributes->twMerge(["w-full h-full min-h-full px-3 mx-auto max-w-7xl "])}}>
        {{$body}}
    </div>
    @endisset
    @if($attributes->has("dismissable"))
    <div x-bind="dismissTrigger" @isset($dismissTrigger) {{$dismissTrigger->attributes}} @endisset>
        @isset($dismissTrigger)
        {{$dismissTrigger}}
        @else
        <x-aui::button variant="ghost" size="icon">
            <x-aui::x class="fill-foreground" />
        </x-aui::button>
        @endisset
    </div>
    @endif
</div>
