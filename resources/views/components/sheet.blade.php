@php

$class = "fixed z-50 gap-4 bg-background p-6 shadow-lg
transition ease-in-out data-[state=open]:animate-in data-[state=closed]:animate-out
data-[state=closed]:duration-300 data-[state=open]:duration-500 ";

if (isset($content)){
$class .= match($content->attributes->get("side")){
default => "inset-y-0 right-0 h-full w-3/4 border-l data-[state=closed]:slide-out-to-right
data-[state=open]:slide-in-from-right sm:max-w-sm",
'top' => "inset-x-0 w-full top-0 border-b data-[state=closed]:slide-out-to-top data-[state=open]:slide-in-from-top",
'bottom' => "inset-x-0 bottom-0 border-t data-[state=closed]:slide-out-to-bottom
data-[state=open]:slide-in-from-bottom",
'left' => "inset-y-0 left-0 h-full w-3/4 border-r data-[state=closed]:slide-out-to-left
data-[state=open]:slide-in-from-left sm:max-w-sm",
'right' => "inset-y-0 right-0 h-full w-3/4 border-l data-[state=closed]:slide-out-to-right
data-[state=open]:slide-in-from-right sm:max-w-sm",
"none" => "",
};

$transitionEnterStart = match($content->attributes->get("side")){
'top' => '-translate-y-10',
'bottom' => 'translate-y-10',
'left' => '-translate-x-3/4',
'right' => 'translate-x-3/4',
default => 'translate-x-3/4',
'none' => '',
};

$transitionEnterEnd = match($content->attributes->get("side")){
'top' => 'translate-y-0',
'bottom' => 'translate-y-0',
'right' => 'translate-x-0',
'left' => 'translate-x-0',
default => 'translate-x-0',
'none' => '',
};

$transitionLeaveStart = match($content->attributes->get("side")){
'top' => 'translate-y-0',
'bottom' => 'translate-y-0',
'right' => 'translate-x-0',
'left' => 'translate-x-0',
default => 'translate-x-0',
'none' => '',
};

$transitionLeaveEnd = match($content->attributes->get("side")){
'top' => '-translate-y-3/4',
'bottom' => 'translate-y-3/4',
'left' => '-translate-x-3/4',
'right' => 'translate-x-3/4',
default => 'translate-x-3/4',
'none' => '',
};
}
@endphp

<div x-data="dialog(false, {{$attributes->has('dismissable') ? 'true' : 'false'}})" x-bind="root" @isset($group)
    {{$group->attributes}} @endisset>
    <div x-bind="trigger" @isset($trigger) {{$trigger->attributes}} @endisset>
        @isset($trigger)
        {{$trigger}}
        @endisset
    </div>

    <template @if ($attributes->has('x-teleport')) x-teleport="{{$attributes->get('x-teleport')}}"
        @else x-if="true"
        @endif>
        <div {{$attributes->except(['x-teleport'])->twMerge(["fixed inset-0 z-50 bg-black/80"])}}
            x-bind="overlay">
            @isset($content)
            <div x-data="sheet('{{$content->attributes->get('side')}}','{{$transitionEnterStart}}','{{$transitionEnterEnd}}','{{$transitionLeaveStart}}','{{$transitionLeaveEnd}}')"
                x-bind="root" {{$content->
                attributes->twMerge(["$class"])}}
                >
                {{$content}}
            </div>
            @endisset
        </div>
    </template>
</div>
