<div x-data="accordion('{{$attributes->get('type') ?? 'multiple'}}', {{$attributes->has('collapsible') ? 'true' : 'false'}}, {{$attributes->has('disabled') ? 'true' : 'false'}})"
    {{$attributes->merge(['class' => "w-full"])}}>
    {{$slot}}
</div>
