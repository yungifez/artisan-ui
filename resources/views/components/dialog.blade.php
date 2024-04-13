@props([
    'popupButtonClass' => '',
    'popupButtonText' => 'Open',
])
<div x-data="{
    dialog : false,
    close(){
        this.dialog = false;
    }, open(){
        this.dialog = true;
    }}"
    @if ($attributes->has("dismissable"))
        @keydown.esc="close()"
    @endif
    @isset($group)
       {{$group->attributes}}
    @endisset
>
    <div @click="open" @isset($trigger) {{$trigger->attributes}} @endisset>
        @isset($trigger)
            {{$trigger}}
        @else
            <x-aui::button
                type="button"
                class="{{$popupButtonClass}}"
            >
                {{$popupButtonText}}
            </x-aui::button>
        @endisset
    </div>

    <div
        class="fixed inset-0 z-50 bg-black/80"
        @if ($attributes->has("dismissable"))
           @click="close()"
        @endif
        x-show="dialog"
        x-trap.noscroll="dialog"
        style="display: none"
        x-transition.opacity
   >
        <div {{$attributes->class(["fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg"])}}
            @click.stop
        >
            <div class="@isset($header){{$header->attributes->get('class')}}@endisset flex flex-col space-y-1.5 text-center sm:text-left" @isset($header) {{$header->attributes}} @endisset>
                @isset($title)
                    <h4 {{$title->attributes->class(["text-lg font-semibold leading-none tracking-tight"])}}>{{$title}}</h4>
                @endisset
                @isset($description)
                    <p {{$description->attributes->class(["text-sm text-muted-foreground"])}}>
                        {{$description}}
                    </p>
                @endisset
            </div>
            @isset($body)
                <div {{$body->attributes}}>
                    {{$body}}
                </div>
            @endisset
            <div class=" flex gap-2 flex-col md:flex-row md:justify-end items-center p-2">
                @if ($attributes->has("dismissable") && !$attributes->has('removeFooterDismissButton'))
                    <div @click="close()" class="w-full md:w-fit">
                        @isset($closeButton)
                            {{$closeButton}}
                        @else
                            <x-aui::button variant="outline" class="w-full">Close</x-aui::button>
                        @endisset
                    </div>
                @endif
                @isset($footer)
                    <div {{$footer->attributes->class(["flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2"])}}>
                        {{$footer}}
                    </div>
                @endisset
            </div>
        </div>
    </div>
</div>
