<div {{$attributes->class(["flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2"])}}>
    @isset($close)
    <div x-bind="closeButton" {{$close->attributes}}>
        {{$close}}
    </div>
    @else
    <button type="button"
        class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none ">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" h-4 w-4">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
        </svg>
        <span class="sr-only">Close</span>
    </button>
    @endisset
    {{$slot}}
</div>
