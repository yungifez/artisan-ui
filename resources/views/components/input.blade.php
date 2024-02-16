@props(['id' => '', 'name' => '', 'label' => '', 'value' => null, 'class' => '', 'groupClass' => 'my-3', 'labelClass' => '', 'errorBag' => 'default', 'errorName' => '', 'oldName' => '', 'inputBlockClass' => '', 'defaultClass' => 'flex py-3 px-4 accent-black rounded-md border dark:border-gray-500 border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors file:border-0 file:bg-transparent file:text-sm dark:file:text-gray-200 file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50'])

@php($isCheckbox = in_array($attributes->get('type'), [ 'checkbox', 'radio'])  )
@php($errorName = $errorName == $errorName ?? $name)
@php($oldName = $oldName == '' ? $oldName : $name)
<div @class([ 'flex-row w-fit flex-wrap' => $isCheckbox,  'flex-col w-full' => !$isCheckbox, "$groupClass flex"])>
    @if (!empty($label))
        <label for="{{$id}}" @class(["$labelClass font-semibold dark:text-gray-200 text-gray-700", 'order-2 mx-2 cursor-pointer' => $isCheckbox,  'my-2' => !$isCheckbox])>{{$label}}</label>
    @endif
    <input id="{{$id}}" name="{{$name}}" @class(["$class $defaultClass order-1 text-gray-300 ", 'border-red-500 ' => $errors->$errorBag->has($errorName),'w-full' => !$isCheckbox]) {{$attributes}} @if(!$isCheckbox) value="{{old($oldName) ?? ($value != null ? $value : '')}}" @else @checked(old($oldName) ?? $attributes->get('checked')) @endif>
    @error($errorName, $errorBag)
        <p class="text-red-500 my-2 order-3 ">{{$message}}</p>
    @enderror
</div>
