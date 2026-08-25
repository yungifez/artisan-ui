@props(['value' => '', 'disabled' => false])

<div data-slot="combobox-option" role="option" data-value="{{$value}}" data-disabled="@js($disabled)"
    x-bind="option" tabindex="-1"
    {{$attributes->twMerge(['flex cursor-default items-center rounded-sm px-2 py-1.5 text-sm outline-none data-[active=true]:bg-accent data-[active=true]:text-accent-foreground data-[disabled=true]:pointer-events-none data-[disabled=true]:opacity-50'])}}>
    <span class="mr-2 flex size-4 items-center justify-center" aria-hidden="true">
        <span x-show="isSelectedValue($el.closest('[data-value]').dataset.value)">✓</span>
    </span>
    <span>{{$slot}}</span>
</div>
