@props([
    'id' => null,
    'name' => null,
    'labelChecked' => null,
    'labelUnchecked' => null,
    'groupClass' => null,
    'color' => 'peer-checked:bg-black text-white peer-focus:ring-gray-700',
])
<div x-data="{ switchOn: '{{$attributes->has('checked') && $attributes->get('checked') != false ? true : false}}' ?? false, labelText: null}" class="flex items-center justify-center space-x-2 w-fit">
    <input id="{{$id}}" type="checkbox" name="{{$name}}" class="hidden" :checked="switchOn" {{$attributes}}
        @if ($attributes->has('x-model'))
            x-model="{{$attributes->get('x-model')}}"
        @endif
    >

    <button
        x-ref="switchButton"
        type="button"
        @click="switchOn = ! switchOn"
        :class="switchOn ? 'bg-black-600 dark:bg-white' : 'bg-neutral-200 dark:bg-neutral-700'"
        class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10"
        x-cloak>
        <span :class="switchOn ? 'translate-x-[18px]' : 'translate-x-0.5'" class="w-5 h-5 duration-200 ease-in-out bg-white dark:bg-black rounded-full shadow-md"></span>
    </button>

    <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
        x-effect="switchOn ? labelText =  '{{$labelChecked}}' : labelText =  '{{$labelUnchecked}}'"
        class="text-sm select-none"
        x-cloak>
        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-200" x-text="labelText"></span>
    </label>
</div>
