@props(['id' => '', 'name' => '', 'label' => '', 'value' => null, 'class' => '', 'groupClass' => 'my-3', 'labelClass' => '', 'errorBag' => 'default', 'errorName' => '', 'oldName' => '', 'inputBlockClass' => '', 'defaultClass' => 'border border-gray-500 p-3 rounded disabled:bg-gray-50'])

@php($isCheckbox = in_array($attributes->get('type'), [ 'checkbox', 'radio'])  )
@php($errorName = $errorName == $errorName ?? $name)
@php($oldName = $oldName == '' ? $oldName : $name)
<div @class([ 'flex-row w-fit flex-wrap' => $isCheckbox,  'flex-col w-full' => !$isCheckbox, "$groupClass flex"])>
    @if (!empty($label))
        <label for="{{$id}}" @class(["$labelClass font-semibold text-gray-700", 'order-2 mx-2 cursor-pointer' => $isCheckbox,  'my-3' => !$isCheckbox])>{{$label}}</label>
    @endif
    <input id={{$id}} name="{{$name}}" @class(["$class $defaultClass", 'border-red-500 ' => $errors->$errorBag->has($errorName),'w-full' => !$isCheckbox]) {{$attributes}} @if(!$isCheckbox) value="{{old($oldName) ?? ($value != null ? $value : '')}}" @else @checked(old($oldName) ?? $attributes->get('checked')) @endif>
    @error($errorName, $errorBag)
        <p class="text-red-500 my-2 order-3 ">{{$message}}</p>
    @enderror
</div>