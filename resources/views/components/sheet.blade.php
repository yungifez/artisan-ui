@php

$class = "fixed z-50 gap-4 bg-background p-6 shadow-lg";

if (isset($content)){
$class .= match($content->attributes->get("side")){
default => "inset-y-0 right-0 h-full w-3/4 border-l sm:max-w-sm",
'top' => "inset-x-0 w-full top-0 border-b",
'bottom' => "inset-x-0 bottom-0 border-t",
'left' => "inset-y-0 left-0 h-full w-3/4 border-r sm:max-w-sm",
'right' => "inset-y-0 right-0 h-full w-3/4 border-l sm:max-w-sm",
"none" => "",
};

}
@endphp

<div data-slot="sheet" data-state="closed" x-data="dialog(false, {{$attributes->has('dismissable') ? 'true' : 'false'}})" x-bind="root" @isset($group)
    {{$group->attributes}} @endisset>
    <div data-slot="sheet-trigger" x-bind="trigger" @isset($trigger) {{$trigger->attributes}} @endisset>
        @isset($trigger)
        {{$trigger}}
        @endisset
    </div>

    <template @if ($attributes->has('x-teleport')) x-teleport="{{$attributes->get('x-teleport')}}"
        @else x-if="true"
        @endif>
        <div data-slot="sheet-overlay" {{$attributes->except(['x-teleport'])->twMerge(["fixed inset-0 z-50 bg-black/80"])}}
            x-bind="overlay" role="presentation">
            @isset($content)
            <div data-slot="sheet-content" role="dialog" data-state="closed" x-data="sheet('{{$content->attributes->get('side')}}')"
                x-bind="root" {{$content->
                attributes->twMerge(["$class"])}}
                >
                {{$content}}
            </div>
            @endisset
        </div>
    </template>
</div>
