@props([
    'variant' => 'default',
    'align' => 'start',
])

@php
$variantClass = match ($variant) {
    'secondary' => 'bg-secondary text-secondary-foreground',
    'muted' => 'bg-muted text-muted-foreground',
    'tinted' => 'bg-primary/10 text-foreground',
    'outline' => 'border bg-background text-foreground',
    'ghost' => 'max-w-none bg-transparent text-foreground',
    'destructive' => 'bg-destructive text-destructive-foreground',
    default => 'bg-primary text-primary-foreground',
};
$alignClass = $align === 'end' ? 'ml-auto' : 'mr-auto';
$slotAttributes = static fn ($slot) => $slot instanceof \Illuminate\View\ComponentSlot
    ? $slot->attributes
    : new \Illuminate\View\ComponentAttributeBag;
@endphp

<div data-slot="bubble" data-variant="{{$variant}}" data-align="{{$align}}"
    {{$attributes->twMerge(["flex w-fit max-w-[80%] $alignClass rounded-2xl px-4 py-2.5 text-sm $variantClass"])}}>
    <div data-slot="bubble-content" class="min-w-0">
        {{$slot}}
    </div>
    @isset($reactions)
    <div data-slot="bubble-reactions" {{$slotAttributes($reactions)->twMerge(['ml-2 flex shrink-0 items-center gap-1'])}}>
        {{$reactions}}
    </div>
    @endisset
</div>
