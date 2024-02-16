<div
    x-data="{open: false}"
    x-id="['accordion-item']"
    $id('accordion-item')
    x-effect="active != $id('accordion-item') ? open = false : open = true"
    class="w-full scroll-smooth" {{$attributes}}>
    <div
        class="w-full my-1"
        @click="
            if(open){
                open = false;
                active = null;
            }else {
                open = true;
                active = $id('accordion-item');
            }
        "
    >
        <div class="">
            <button class="flex items-center justify-between w-full p-2 px-4 text-left select-none group-hover:underline">
                <div>
                    {{$title}}
                </div>
                <span x-text="open == false ? '+' : '-'" class="text-2xl">
                </span>
            </button>
            <div x-show="active == $id('accordion-item')"
                class="scroll-smooth p-4 text-gray-500 dark:text-gray-50 pt-0"
                x-collapse
                x-cloak
            >
                {{$slot}}
            </div>
        </div>
    </div>
</div>
