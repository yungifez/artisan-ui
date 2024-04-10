<div
    x-data="{
        popover : false,
        close(){
            this.popover = false;
        },
        open(){
            this.popover = true;
        },
        toggle(){
            this.popover == true ? this.close() : this.open()
        }
    }"
>
    <div
        class="w-fit inline-block"
        @click="toggle()"
        x-ref="trigger"
    >
        @isset($popoverTrigger)
            {{$popoverTrigger}}
        @else
            <x-aui::button variant="outline" type="button">Open</x-aui::button>
        @endisset
    </div>
    @isset($popoverContent)
        <div x-anchor.offset.4="$refs.trigger" x-show="popover" x-transition {{$popoverContent->attributes->class(["z-50 w-72 rounded-md border bg-popover p-4 text-popover-foreground shadow-md outline-none"])}}>
            {{$popoverContent}}
        </div>
    @endisset
</div>
