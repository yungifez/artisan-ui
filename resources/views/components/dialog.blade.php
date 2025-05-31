<div x-data="dialog(false, {{$attributes->has('dismissable') ? 'true' : 'false'}})" x-bind="root" @isset($group)
    {{$group->attributes}} @endisset>
    <div x-bind="trigger" @isset($trigger) {{$trigger->attributes}} @endisset>
        @isset($trigger)
        {{$trigger}}
        @endisset
    </div>

    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        <div {{$attributes->except(['x-teleport'])->twMerge(["fixed min-h-[100vh] inset-0 z-50 bg-black/80" ])}}
            x-bind="overlay" role="dialog">
            @isset($content)
            <div x-bind="dialog" {{$content->attributes->twMerge(["fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg
                translate-x-[-50%]
                translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg"])}}
                >
                {{$content}}
            </div>
            @endisset
        </div>
        @if ($attributes->has('x-teleport'))
    </template>
    @endif
</div>
