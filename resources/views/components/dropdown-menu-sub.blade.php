<div
    x-data="{
        'subOpen' : false,
        'subPreview' : false,
        open(){
            this.subOpen = true
        },
        close(){
            this.subOpen = false
        },
        toggle(){
            this.subOpen == true ? this.close() : this.open()
        },
        openPreview(){
            this.subPreview = true;
        },
        closePreview(){
            this.subPreview = false;
        }
    }"
    role="menuitem"
    aria-haspopup="menu"
    :aria-expanded="true"
    @keydown.escape="close()"
    @keydown.right="open()"
    @keydown.left="close()"
    @click.outside="close()"
    {{$attributes}}
>
    @isset($dropdownMenuSubTrigger)
        <button type="button"
            @click="toggle()"
            x-ref="subTrigger"
            @mouseover="$el.focus(); openPreview()"
            @mouseout="$el.focus(); closePreview()"
            :class="{'bg-accent' : subOpen}"
            {{$dropdownMenuSubTrigger->attributes->class(["flex w-full cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none focus:bg-accent"])}}
        >
               {{$dropdownMenuSubTrigger}}
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right ml-auto h-4 w-4"><path d="m9 18 6-6-6-6"></path></svg>
        </button>
    @endisset
    @isset($dropdownMenuSubContent)
        {{--dont remove this if statement, it makes sure the items can be navigated using arrow keys--}}
        <template x-if="subOpen || subPreview">
            <div
                x-show="subOpen || subPreview"
                x-transition
                x-trap.noscroll="subOpen"
                x-anchor.left-start.right-start="$refs.subTrigger"
                x-cloak
                {{$attributes->class(['z-50 min-w-[8rem] overflow-hidden rounded-md border bg-popover p-1 text-popover-foreground shadow-lg'])}}
            >
                {{$dropdownMenuSubContent}}
            </div>
        </template>
    @endisset
</div>
