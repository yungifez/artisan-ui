@props([
    'name' => '',
    'value' => '',
    'placeholder' => 'Select an option...',
    'disabled' => false,
])

<div data-slot="combobox" data-state="closed"
    x-data="combobox(@js($value), @js($disabled))" x-bind="root" x-modelable="selectedValue"
    {{$attributes->twMerge(['relative w-full'])}}>
    @if ($name !== '')
    <input type="hidden" name="{{$name}}" x-model="selectedValue">
    @endif
    @isset($trigger)
    <div data-slot="combobox-trigger" x-bind="trigger" x-ref="trigger" {{$trigger->attributes}}>
        {{$trigger}}
    </div>
    @else
    <button type="button" data-slot="combobox-trigger" x-bind="trigger"
        x-ref="trigger"
        class="flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50">
        <span class="truncate" x-text="selectedLabel() || @js($placeholder)"></span>
        <span aria-hidden="true" class="ml-2 text-muted-foreground">⌄</span>
    </button>
    @endisset
    <div data-slot="combobox-content" x-bind="content" x-show="open" x-trap.noscroll="open" x-transition x-cloak
        class="absolute z-50 mt-2 w-full rounded-md border bg-popover p-1 text-popover-foreground shadow-md">
        <input data-slot="combobox-input" x-bind="input" type="text" autocomplete="off"
            x-ref="input"
            placeholder="Search..."
            class="flex h-9 w-full rounded-sm bg-transparent px-2 py-1 text-sm outline-none placeholder:text-muted-foreground">
        <div data-slot="combobox-list" x-bind="list" role="listbox" class="mt-1 max-h-60 overflow-y-auto">
            {{$slot}}
        </div>
        @isset($empty)
        <div data-slot="combobox-empty" x-show="noMatches()"
            class="px-2 py-6 text-center text-sm text-muted-foreground">
            {{$empty}}
        </div>
        @endisset
    </div>
</div>
