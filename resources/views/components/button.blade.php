@props(
    [
        'color' => 'bg-[color:var(--button-bg-color)] dark:bg-[color:var(--button-dark-bg-color)] text-[color:var(--button-text-color)] dark:text-[color:var(--button-dark-text-color)] focus:ring-[var(--button-focus-ring-color)] dark:focus:ring-[var(--button-dark-focus-ring-color)] ',
        'class' => ' my-3',
        'icon' => '',
        'label' => ''
    ]
)

<button @class(["$class $color shadow-sm hover:bg-opacity-80 focus:ring-1 active:bg-opacity-70 py-2 px-4 rounded capitalize"] ) {{$attributes}}>
    <i class="{{$icon}}" aria-hidden="true"></i>
    {{$slot}} {{$label}}
</button>
