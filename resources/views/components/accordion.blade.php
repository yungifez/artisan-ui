@props(['groupTogether' => false, 'groupClass' => '', 'titleClass' => '', 'bodyClass' => '' ])

<div x-data="{active: 1, groupTogether: {{$groupTogether}}}" class="{{$groupClass}} relative w-full mx-auto overflow-hidden text-sm font-normal bg-white border border-gray-200 divide-y divide-gray-200 rounded-md" {{$attributes}}>
    {{$slot}}
</div>
