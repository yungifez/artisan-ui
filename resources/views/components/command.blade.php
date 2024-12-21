@props(['input', 'list', 'icon', 'value' => '', 'empty' => ''])
<div x-data='command(@json($value))' x-bind="root" {{$attributes->class(['flex h-full w-full flex-col overflow-hidden
    rounded-md
    bg-popover
    text-popover-foreground'])}} x-modelable="value">
    <div class="flex items-center border-b px-3">
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
        <input x-bind="input" x-ref="input"
            class="{{!isset($input->attributes) ?: $input->attributes->get('class')}} flex h-11 w-full rounded-md bg-transparent py-3 text-sm outline-none placeholder:text-muted-foreground disabled:cursor-not-allowed disabled:opacity-50"
            {{ !isset($input->attributes) ?: $input->attributes->except(['class'])}}/>
    </div>
    @isset($list)
    <div x-ref="list">
        {{$list}}
    </div>
    <div class="py-6 text-center text-sm" x-bind="commandEmpty">
        {{$empty}}
    </div>
    @endisset
</div>
