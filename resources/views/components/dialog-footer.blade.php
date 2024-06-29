<div {{$attributes->class(["flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2"])}}>
    @isset($close)
    <div x-bind="closeButton" {{$close->attributes}}>
        {{$close}}
    </div>
    @endisset
    {{$slot}}
</div>
