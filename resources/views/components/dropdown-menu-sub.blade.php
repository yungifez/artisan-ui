<div x-data="dropdownMenuSub" x-bind="root" role="menuitem" aria-haspopup="menu" {{$attributes}}>
    @isset($trigger)
    <x-aui::button variant="ghost" size="none" type="button" x-ref="subTrigger" tabindex="-1" x-bind="trigger"
        ::class="{'bg-accent' : subOpen || subPreview}" :attributes="$trigger->attributes->twMerge(['flex w-full cursor-default
        select-none items-center rounded-sm
        px-2 py-1.5 text-sm outline-none focus:bg-accent'])">
        {{$trigger}}
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-chevron-right ml-auto h-4 w-4">
            <path d="m9 18 6-6-6-6"></path>
        </svg>
    </x-aui::button>
    @endisset
    @isset($content)
    {{--dont remove this template, it makes sure the items can be navigated using arrow keys--}}
    <template x-bind="template">
        <div x-bind="content" {{$content->attributes->twMerge(['z-50 min-w-[8rem] rounded-md border
            bg-popover p-1
            text-popover-foreground shadow-lg'])}}
            >
            {{$content}}
        </div>
    </template>
    @endisset
</div>
