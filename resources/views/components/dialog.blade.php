<div x-data="dialog(false, {{$attributes->has('dismissable') ? 'true' : 'false'}})" x-bind="root" @isset($group)
    {{$group->attributes}} @endisset>
    <div x-bind="trigger" @isset($trigger) {{$trigger->attributes}} @endisset>
        @isset($trigger)
        {{$trigger}}
        @endisset
    </div>

    <template @if ($attributes->has('x-teleport')) x-teleport="{{$attribute->get('x-teleport')}}" @else x-if="true"
        @endif>
        <div {{$attributes->class(["fixed min-h-[100vh] inset-0 z-50 bg-black/80" ])}} x-bind="overlay">
            @isset($content)
            <div x-bind="dialog" {{$content->attributes->class(["fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg
                translate-x-[-50%]
                translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg"])}}
                >
                {{$content}}
            </div>
            @endisset
        </div>
    </template>
</div>
