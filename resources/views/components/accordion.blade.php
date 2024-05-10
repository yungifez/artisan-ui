<div x-data="accordion('{{$attributes->get('type') ?? 'multiple'}}', {{$attributes->has('collapsible') ? 'true' : 'false'}}, {{$attributes->has('disabled') ? 'true' : 'false'}})"
    {{$attributes->merge(['class' => "border-border
    divide-border
    relative w-full mx-auto overflow-hidden text-sm font-normal border-b divide-y rounded-md"])}} {{$attributes}}>
    {{$slot}}
</div>
