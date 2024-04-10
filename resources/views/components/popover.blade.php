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
        @keydown.escape="close()"
        x-ref="trigger"
    >
        @isset($popoverTrigger)
            {{$popoverTrigger}}
        @else
            <x-aui::button variant="outline" type="button">Open</x-aui::button>
        @endisset
    </div>
    @isset($popoverContent)
        <div x-anchor.offset.4="$refs.trigger" x-trap="popover" @click.outside="close()" x-show="popover" x-transition {{$popoverContent->attributes->class(["rounded-md border bg-popover text-popover-foreground shadow-md outline-none"])}}>
            {{$popoverContent}}
        </div>
    @endisset
</div>
