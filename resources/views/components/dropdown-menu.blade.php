<div
    x-data="{
        dropdownMenu : false,
        close(){
            this.dropdownMenu = false;
        },
        open(){
            this.dropdownMenu = true;
        },
        toggle(){
            this.dropdownMenu == true ? this.close() : this.open()
        }
    }"
>
    <div
        class="w-fit inline-block"
        @click="toggle()"
        @keydown.escape="close()"
        x-ref="trigger"
    >
        @isset($dropdownMenuTrigger)
            {{$dropdownMenuTrigger}}
        @else
            <x-aui::button variant="outline" type="button">Open</x-aui::button>
        @endisset
    </div>
    @isset($dropdownMenuContent)
        <div
        x-anchor.offset.4="$refs.trigger"
        @keydown.down.prevent="$focus.next()"
        @keydown.up.prevent="$focus.previous()"
        @keydown.tab.prevent="close()"
        x-trap.noscroll="dropdownMenu"
        @click.outside="close()"
        x-show="dropdownMenu"
        x-transition
        {{$dropdownMenuContent->attributes->class(["z-50 min-w-[8rem]  rounded-md border bg-popover p-1 text-popover-foreground shadow-lg"])}}
        >
            {{$dropdownMenuContent}}
        </div>
    @endisset
</div>
