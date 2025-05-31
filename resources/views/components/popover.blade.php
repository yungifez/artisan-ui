<div x-data="popover" {{$attributes->except(['x-teleport'])}}>
    <div x-bind="trigger" class="w-fit inline-block" x-ref="trigger">
        @isset($popoverTrigger)
        {{$popoverTrigger}}
        @else
        <x-aui::button variant="outline" type="button">Open</x-aui::button>
        @endisset
    </div>
    @isset($popoverContent)
    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        <div x-cloak x-bind="content" {{$popoverContent->attributes->twMerge(["z-50 w-72 rounded-md border bg-popover
            p-4
            text-popover-foreground shadow-md outline-none"])}}>
            {{$popoverContent}}
        </div>
        @if ($attributes->has('x-teleport'))
    </template>
    @endif
    @endisset
</div>
