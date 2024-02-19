@props(
    [
        'id' => '',
        'name' => '',
        'label' => '',
        'value' => null,
        'class' => '',
        'groupClass' => 'my-3',
        'labelClass' => '',
        'errorBag' => 'default',
        'errorName' => '',
        'oldName' => '',
        'inputBlockClass' => '',

        'color' => 'bg-[color:var(--input-bg-color)] dark:bg-[color:var(--input-dark-bg-color)] accent-[var(--input-accent-color)] dark:accent-[var(--input-dark-accent-color)] text-[color:var(--input-text-color)] dark:text-[color:var(--input-dark-text-color)] focus:ring-[var(--input-accent-color)] dark:focus:ring-[color:var(--input-dark-accent-color)] border-[color:var(--input-border-color)] dark:border-[color:var(--input-dark-border-color)] file:bg-[color:var(--input-file-bg-color)] dark:file:bg-[color:var(--input-dark-file-bg-color)] file:text-[color:var(--input-file-text-color)] dark:file:text-[color:var(--input-dark-file-text-color)] placeholder-[color:var(--input-placeholder-color)] dark:placeholder-[var(--input-dark-placeholder-color)]',

        'labelColor' => 'text-[var(--input-text-color)] dark:text-[var(--input-dark-text-color)]',

        'defaultClass' => 'flex py-3 px-4 rounded-md border border-input px-3 py-1 text-sm shadow-sm transition-colors file:border-0  file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50'
    ]
)

@php
    $isCheckbox = in_array($attributes->get('type'), [ 'checkbox', 'radio', 'range']);
    $errorName = $errorName == $errorName ?? $name;
    $oldName = $oldName == '' ? $oldName : $name;
@endphp

<div @class([ 'flex-row w-fit items-center flex-wrap' => $isCheckbox,  'flex-col w-full' => !$isCheckbox, "$groupClass flex"])>
    @if (!empty($label))
        <label for="{{$id}}" @class(["$labelColor $labelClass font-semibold ", 'order-2 mx-2 cursor-pointer' => $isCheckbox,  'my-2' => !$isCheckbox])>{{$label}}</label>
    @endif
    <input id="{{$id}}" name="{{$name}}" @class(["$color $class $defaultClass order-1 ", 'border-red-500 ' => $errors->$errorBag->has($errorName),'w-full' => !$isCheckbox]) {{$attributes}} @if(!$isCheckbox) value="{{old($oldName) ?? ($value != null ? $value : '')}}" @else @checked(old($oldName) ?? $attributes->get('checked')) @endif>
    @error($errorName, $errorBag)
        <p class="text-red-500 my-2 order-3 ">{{$message}}</p>
    @enderror
</div>
