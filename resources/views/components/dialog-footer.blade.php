<div {{$attributes->twMerge(["flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2"])}}>

    <template x-if="dismissable">
        <div x-bind="closeButton" @isset($close) {{$close->attributes}} @endisset
            >
            @isset($close)
            {{$close}}
            @else
            <button type="button"
                class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none ">
                <x-aui::x class="fill-foreground" />
                <span class="sr-only">Close</span>
            </button>
            @endisset
        </div>
    </template>
    {{$slot}}
</div>
