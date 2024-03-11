@props([
    'label' => '',
    'color' => 'text-[var(--primary-accent-text-color)] dark:text-[var(--dark-primary-accent-text-color)] bg-[color:var(--primary-accent-color)] dark:bg-[color:var(--dark-primary-accent-color)]',
    'class' => ''
])

<div class="{{$class}} {{$color}} inline-flex items-center rounded-md border px-2 py-1 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent shadow hover:bg-opacity-80 text-capitalize" {{$attributes}} >{{$label}}</div>
