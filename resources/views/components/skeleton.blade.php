<div {{$attributes->merge(["data-slot" => "skeleton"])->twMerge(['animate-pulse rounded-md bg-muted'])}}>
    {{$slot}}
</div>
