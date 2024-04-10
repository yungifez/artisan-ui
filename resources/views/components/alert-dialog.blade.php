@props([
    'title',
    'icon',
    'class' => '',
    'timeout' => '5000',
    'canDismiss' => false,
    'dismissOnTimeout' => false
])

@php
    $class = "relative w-full rounded-lg border p-4 flex gap-x-3 ";

    $class .= match($attributes->get("variant")){
        default => "bg-background text-foreground fill-foreground",
        'destructive' =>  "border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive fill-destructive",
        "none" => "",
    };
@endphp

<div  aria-role="alert" x-data="{'showAlert' : true,
    close(){
        this.showAlert = false;
        {{$attributes->get("onclose")}}
    }}"
    x-show="showAlert"
    x-transition
    {{$attributes->class(["$class"])}}
>

    @isset($icon)
        <div
            class="flex items-start mt-2"
            {{$icon->attributes}}
        >
            {{$icon}}
        </div>
    @endisset

    @if ($dismissOnTimeout == true && $canDismiss == true)
        <span x-init="setTimeout(() => { close() }, {{$timeout}});"></span>
    @endif

    <div class="w-full">
        @isset($title)
            <h5 {{$title->attributes->class(["mb-1 font-medium leading-none tracking-tight"])}}>
                {{$title}}
            </h5>
        @endisset
        @isset($description)
            <div {{$description->attributes->class(["text-sm"])}}>
                {{$description}}
            </div>
        @endisset
    </div>
    <div>
        @if ($canDismiss == true)
        <button @click="close()">
            @if($attributes->has('close-icon'))
                {{$attributes->get('close-icon')}}
            @else
                <x-aui::x />
            @endif
            <p class="sr-only">Close Alert</p>
        </button>
        @endif
    </div>
</div>
