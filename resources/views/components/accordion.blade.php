@props([
    'groupTogether' => false,
    'class' => '',
    'color' => "text-[var(--accordion-text-color)] dark:text-[var(--accordion-dark-text-color)] border-[color:var(--accordion-border-color)] dark:border-[color:var(--accordion-dark-border-color)] divide-[color:var(--accordion-border-color)] dark:divide-[color:var(--accordion-dark-border-color)]"
])


<div x-data="{active: 1, groupTogether: {{$groupTogether}}}" class="{{$color}} {{$class}} relative w-full mx-auto overflow-hidden text-sm font-normal border divide-y rounded-md" {{$attributes}}>
    {{$slot}}
</div>
