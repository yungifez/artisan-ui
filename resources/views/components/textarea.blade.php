@props(['id' => '', 'name' => '', 'label' => '', 'value' => null, 'class' => '', 'groupClass' => 'my-3', 'labelClass' => '', 'errorBag' => 'default', 'errorName' => '', 'oldName' => '', 'inputBlockClass' => '', 'defaultClass' => 'flex py-3 px-4 rounded border dark:border-gray-500 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50'])

@php($errorName = $errorName == $errorName ?? $name)
@php($oldName = $oldName == '' ? $oldName : $name)

<div @class(["$groupClass flex flex-col my-2"])>
    @if (!empty($label))
        <label for="{{$id}}" @class(["$labelClass font-semibold text-gray-700 cursor-pointer my-2 dark:text-gray-200"])>{{$label}}</label>
    @endif
    <textarea id="{{$id}}" name="{{$name}}" @class(["$class $defaultClass", 'border-red-500' => $errors->has($errorName)]) {{$attributes}}>{{old($oldName) ?? ($slot != null ? $slot : '')}}</textarea>
    @error($errorName)
        <p class="text-red-500 my-2">{{$message}}</p>
    @enderror
</div>
