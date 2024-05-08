@props([
'name' => null,
'checkedLabel' => null,
'uncheckedLabel' => null,
'label' => '',
'groupClass' => null,
])
<div x-data="switchInput({{$attributes->has('checked') ? 'true' : 'false'}}, {{$attributes->has('disabled') ? 'true' : 'false'}} ,'{{$checkedLabel ?? $label}}', '{{$uncheckedLabel ?? $label}}')"
    class="{{$attributes->get('group-class')}} flex items-center space-x-2 w-fit" {{$attributes->
    whereStartsWith('group')}}>
    <input type="checkbox" name="{{$name}}" class="hidden" x-ref="input" x-bind="input" {{$attributes}}>

    <button x-ref="trigger" type="button" x-bind="trigger"
        :class="{'bg-primary': switchOn,  'bg-input' : !switchOn, 'opacity-60' : disabled}"
        class="inline-flex h-6 py-0.5 rounded-full w-10 accent-accent">
        <span :class="{'translate-x-[18px] bg-background': switchOn,  'translate-x-0.5 bg-background' : !switchOn}"
            class="w-5 h-5 duration-200 ease-in-out rounded-full shadow-md"></span>
    </button>

    <label x-bind="label" class="select-none ml-3 text-sm font-medium text-gray-900 dark:text-gray-200">
    </label>
</div>
