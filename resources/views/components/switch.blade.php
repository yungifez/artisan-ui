@props([
    'id' => null,
    'name' => null,
    'labelChecked' => null,
    'labelUnchecked' => null,
    'labelText' => '',
    'groupClass' => null,
])
<div x-data="{ switchOn: '{{$attributes->has('checked') && $attributes->get('checked') != false ? true : false}}', labelText: null}" class="{{$attributes->get('group-class')}} flex items-center space-x-2 w-fit" {{$attributes->whereStartsWith('group')}}>
    <input id="{{$id}}" type="checkbox" name="{{$name}}" class="hidden" :checked="switchOn" {{$attributes}}
        @if ($attributes->has('x-model'))
            x-model="{{$attributes->get('x-model')}}"
        @endif
    >

    <button
        x-ref="switchButton"
        type="button"
        @click="switchOn = !switchOn"
        :class="switchOn ? 'bg-primary' : 'bg-input'"
        class="inline-flex h-6 py-0.5 rounded-full w-10 accent-accent"
        x-cloak>
        <span :class="switchOn ? 'translate-x-[18px] bg-background' : 'translate-x-0.5 bg-background'" class="w-5 h-5 duration-200 ease-in-out rounded-full shadow-md"></span>
    </button>

    <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
        x-effect="switchOn ? labelText =  '{{$labelChecked ?? $labelText}}' : labelText =  '{{$labelUnchecked ?? $labelText}}'"
        class="text-sm select-none"
        x-cloak>
        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-200" x-text="labelText"></span>
    </label>
</div>
