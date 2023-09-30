@props(['id' => '', 'name' => '', 'label' => '', 'value' => null, 'class' => '', 'groupClass' => 'my-3', 'labelClass' => '', 'errorBag' => 'default', 'errorName' => '', 'oldName' => '', 'inputBlockClass' => '', 'defaultClass' => 'border border-gray-500 p-3 rounded disabled:bg-gray-50'])

@php($isCheckbox = in_array($attributes->get('type'), [ 'checkbox', 'radio'])  )
@php($errorName = $errorName == $errorName ?? $name)
@php($oldName = $oldName == '' ? $oldName : $name)

<div @class(["$groupClass flex flex-col my-2"])>
    @if (!empty($label))
        <label for="{{$id}}" @class(["$labelClass font-semibold text-gray-700", 'order-2 mx-2 cursor-pointer' => $isCheckbox,  'my-3' => !$isCheckbox])>{{$label}}</label>
    @endif
    <textarea id="{{$id}}" name="{{$name}}" @class(["$class $defaultClass", 'border-red-500' => $errors->has($errorName)]) {{$attributes}}>{{old($oldName) ?? ($slot != null ? $slot : '')}}</textarea>
    @error($errorName)
        <p class="text-red-500 my-2">{{$message}}</p>
    @enderror
</div>