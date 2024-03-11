@props([
    'id' => null,
    'name' => null,
    'labelChecked' => null,
    'labelUnchecked' => null,
    'labelText' => '',
    'groupClass' => null,
])
<div x-data="{ switchOn: '{{$attributes->has('checked') && $attributes->get('checked') != false ? true : false}}' ?? false, labelText: null}" class="flex items-center space-x-2 w-fit">
    <input id="{{$id}}" type="checkbox" name="{{$name}}" class="hidden" :checked="switchOn" {{$attributes}}
        @if ($attributes->has('x-model'))
            x-model="{{$attributes->get('x-model')}}"
        @endif
    >

    <button
        x-ref="switchButton"
        type="button"
        @click="switchOn = ! switchOn"
        :class="switchOn ? 'bg-[color:var(--switch-on-bg-color)] dark:bg-[color:var(--switch-dark-on-bg-color)]' : 'bg-neutral-200 dark:bg-neutral-700'"
        class="inline-flex h-6 py-0.5 rounded-full w-10"
        x-cloak>
        <span :class="switchOn ? 'translate-x-[18px] bg-[color:var(--switch-on-fill-color)] dark:bg-[color:var(--switch-dark-on-fill-color)]' : 'translate-x-0.5 bg-[color:var(--switch-off-fill-color)] dark:bg-[color:var(--switch-dark-off-fill-color)]'" class="w-5 h-5 duration-200 ease-in-out rounded-full shadow-md"></span>
    </button>

    <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
        x-effect="switchOn ? labelText =  '{{$labelChecked ?? $labelText}}' : labelText =  '{{$labelUnchecked ?? $labelText}}'"
        class="text-sm select-none"
        x-cloak>
        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-200" x-text="labelText"></span>
    </label>
</div>
