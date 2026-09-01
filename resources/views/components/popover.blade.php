@php
// `popoverTrigger` and `popoverContent` are the legacy slot names. Accept the
// generic overlay names as the canonical API.
$trigger = $trigger ?? $popoverTrigger ?? null;
$content = $content ?? $popoverContent ?? null;
@endphp

<div data-slot="popover" data-state="closed" x-data="popover" {{$attributes->except(['x-teleport'])}}>
    <div data-slot="popover-trigger" x-bind="trigger" class="w-fit inline-block" x-ref="trigger">
        @isset($trigger)
        {{$trigger}}
        @else
        <april:button variant="outline" type="button">Open</april:button>
            @endisset
    </div>
    @isset($content)
    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        <div data-slot="popover-content" role="dialog" x-cloak x-bind="content" {{$content->attributes->twMerge(["z-50 w-72 rounded-md border bg-popover
            p-4
            text-popover-foreground shadow-md outline-none"])}}>
            {{$content}}
        </div>
        @if ($attributes->has('x-teleport'))
    </template>
    @endif
    @endisset
</div>
