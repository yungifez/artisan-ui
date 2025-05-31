<div x-data="tabsContent('{{$attributes->get('value')}}')" role="tabpanel" x-bind="root" {{$attributes->twMerge(['mt-2
    ring-offset-background
    focus-visible:outline-none focus-visible:ring-2
    focus-visible:ring-ring focus-visible:ring-offset-2'])}}>
    {{$slot}}
</div>
