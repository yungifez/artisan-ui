@props(['separator'])
<li role="presentation" aria-hidden="true" {{$attributes->twMerge(['[&>svg]:w-3.5 [&>svg]:h-3.5'])}}>
    @isset($separator)
    {{$separator}}
    @else
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="m9 18 6-6-6-6"></path>
    </svg>
    @endisset
</li>
