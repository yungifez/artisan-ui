@php($rootAttributes = $attributes->except(['x-teleport', 'dismissable']))

<div data-slot="dialog" data-state="closed" x-data="dialog(false, {{$attributes->has('dismissable') ? 'true' : 'false'}})" x-modelable="open" x-bind="root" {{$rootAttributes}} @isset($group)
    {{$group->attributes}} @endisset>
    <div data-slot="dialog-trigger" x-bind="trigger" @isset($trigger) {{$trigger->attributes}} @endisset>
        @isset($trigger)
        {{$trigger}}
        @endisset
    </div>

    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
        @endif
        <div data-slot="dialog-overlay" class="fixed min-h-[100vh] inset-0 z-50 bg-black/80"
            x-bind="overlay" x-cloak role="presentation">
            @isset($content)
            <div data-slot="dialog-content" role="dialog" x-bind="dialog" {{$content->attributes->twMerge(["fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg
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
