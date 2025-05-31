@props(['input', 'label' => '', 'list', 'icon', 'value' => '', 'empty' => ''])
<div x-data='command(@json($value))' x-bind="root" cmd-root {{$attributes->twMerge(['flex flex-col overflow-hidden
    rounded-md
    bg-popover
    text-popover-foreground'])}} x-modelable="keyword">
    <div cmd-input-wrapper class="flex items-center border-b px-3">
        @isset($icon)
        {{$icon}}
        @else
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-search mr-2 h-4 w-4 shrink-0 opacity-50">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
        </svg>
        @endisset
        <label class="w-full h-fit">
            <span class="sr-only">{{$label}}</span>
            <input x-bind="commandInput" x-ref="input" cmd-input
                class="{{!isset($input->attributes) ?: $input->attributes->get('class')}} flex h-11 w-full rounded-md bg-transparent py-3 text-sm outline-none placeholder:text-muted-foreground disabled:cursor-not-allowed disabled:opacity-50"
                type="text" autocomplete="off" aria-autocomplete="list" autocorrect="off" role="combobox"
                {{!isset($input->attributes) ?: $input->attributes->except(['class'])}}/>
        </label>
    </div>
    @isset($list)
    <div class="max-h-[300px] overflow-y-auto overflow-x-hidden" x-bind="commandList" x-ref="list" role="listbox"
        aria-label="suggestions" cmd-list-sizer>
        {{$list}}
    </div>
    <div class="py-6 text-center text-sm" x-bind="commandEmpty">
        {{$empty}}
    </div>
    @endisset
</div>
