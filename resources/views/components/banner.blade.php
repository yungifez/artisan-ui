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
'top' => 'fixed top-0 left-0 border-b',
'bottom' => 'fixed bottom-0 left-0 border-t',
'none' => 'relative',
default => 'fixed top-0 left-0 border-b',
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

<div data-slot="banner" data-state="closed" x-data="banner({{$displayAfter}},'{{$transitionEnterStart}}','{{$transitionEnterEnd}}','{{$transitionLeaveStart}}','{{$transitionLeaveEnd}}')"
    x-bind="root" {{$attributes->twMerge(["$positionClass bg-background p-3 flex items-center z-20 w-full
    h-auto duration-300 ease-out shadow-sm "])}}
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
        <april:button variant="ghost" size="icon">
            <april:x class="fill-foreground" />
        </april:button>
        @endisset
    </div>
    @endif
</div>
