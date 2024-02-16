@props(['color' => 'bg-black text-white dark:text-black dark:bg-white focus:ring-gray-200', 'class' => ' my-3', 'icon' => '', 'label' => ''])

<button @class(["$class $color shadow-sm hover:bg-opacity-80 focus:ring-2 active:bg-opacity-70 py-2 px-4 rounded capitalize"] ) {{$attributes}}>
    <i class="{{$icon}}" aria-hidden="true"></i>
    {{$slot}} {{$label}}
</button>
