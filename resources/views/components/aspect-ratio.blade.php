@props(['ratio' => 1])

<div data-slot="aspect-ratio" style="aspect-ratio: {{$ratio}};" {{$attributes}}>
    {{$slot}}
</div>
