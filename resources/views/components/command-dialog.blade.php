<div x-data="dialog(false, true)" x-modelable="show" x-bind="root" {{$attributes->
    whereStartsWith('x-model')}} @isset($group) {{$group->attributes}} @endisset>
    @isset($trigger)
    <div x-bind="trigger" @isset($trigger) {{$trigger->attributes}} @endisset>
        {{$trigger}}
    </div>
    @endisset
    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        <div class="fixed min-h-[100vh] inset-0 z-50 bg-black/80" x-bind="overlay" role="dialog">
            <div x-bind="dialog" {{$attributes->
                whereDoesntStartWith('x-model')->except('x-teleport')->twMerge(["fixed left-[50%] top-[50%] z-50
                grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] border bg-background duration-200
                [&_[cmd-root]]:w-full
                [&_[cmd-group-heading]]:px-2 [&_[cmd-group-heading]]:font-medium
                [&_[cmd-group-heading]]:text-muted-foreground [&_[cmd-group]:not([hidden])_~[cmd-group]]:pt-0
                [&_[cmd-group]]:px-2 [&_[cmd-input-wrapper]_svg]:h-5 [&_[cmd-input-wrapper]_svg]:w-5
                [&_[cmd-input]]:h-12 [&_[cmd-item]]:px-2 [&_[cmd-item]]:py-3 [&_[cmd-item]_svg]:h-5
                [&_[cmd-item]_svg]:w-5"])}}
                >
                {{$slot}}
                <div x-bind="closeButton">
                    <button type="button"
                        class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none ">
                        <x-aui::x class="fill-foreground" />
                        <span class="sr-only">Close</span>
                    </button>
                </div>
            </div>
        </div>
        @if ($attributes->has('x-teleport'))
    </template>
    @endif
</div>
