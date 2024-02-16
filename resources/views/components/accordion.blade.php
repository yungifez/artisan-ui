@props(['groupTogether' => false, 'class' => '', 'color' => 'dark:bg-black bg-white dark:text-white'])

<div x-data="{active: 1, groupTogether: {{$groupTogether}}}" class="{{$color}} {{$class}} relative w-full mx-auto overflow-hidden text-sm font-normal border border-gray-200 dark:border-gray-500 divide-y divide-gray-200 divide-gray-500 rounded-md" {{$attributes}}>
    {{$slot}}
</div>
