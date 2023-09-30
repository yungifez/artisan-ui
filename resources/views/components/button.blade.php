@props(['color' => 'bg-blue-700 text-white focus:ring-blue-300', 'class' => ' my-3', 'icon' => '', 'label' => ''])

<button @class(["$class $color hover:bg-opacity-90 focus:ring-4 active:bg-opacity-70 py-2 px-4 rounded capitalize"] ) {{$attributes}}>
    <i class="{{$icon}}" aria-hidden="true"></i>
    {{$slot}} {{$label}}
</button>