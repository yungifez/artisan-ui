<div x-data="{active: 1 }" {{$attributes->merge(['class' => "border-border divide-border relative w-full mx-auto overflow-hidden text-sm font-normal border-b divide-y rounded-md"])}} {{$attributes}}>
    {{$slot}}
</div>
