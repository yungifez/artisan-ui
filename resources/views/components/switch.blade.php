@props([
    'checked' => false,
    'name' => null,
    'id' => null,
    'disabled' => false,
])

<div data-slot="switch" data-state="{{$checked ? 'checked' : 'unchecked'}}" x-data="switchInput({{$disabled ? 'true' : 'false'}}, {{$checked ? 'true' : 'false'}})" x-bind="root" role="switch"
    x-modelable="value" {{$attributes->twMerge(['flex items-center space-x-2
    w-fit'])}} >
    <input type="checkbox" class="hidden" x-ref="input" x-bind="input" @if ($name !== null)
    name="{{$name}}"
    @endif @if ($id !== null) id="{{$id}}" @endif @checked($checked)>

    <button data-slot="switch-thumb" x-ref="trigger" type="button" x-bind="trigger"
        :class="{'bg-primary': value,  'bg-input' : !value, 'opacity-60' : disabled}"
        class="inline-flex h-6 py-0.5 rounded-full w-10 accent-accent">
        <span :class="{'translate-x-[18px] bg-background': value,  'translate-x-0.5 bg-background' : !value}"
            class="w-5 h-5 duration-200 ease-in-out rounded-full shadow-md"></span>
    </button>
</div>
