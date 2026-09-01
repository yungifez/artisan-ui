@props(['dismissable' => false])

@php($rootAttributes = $attributes->except('x-teleport'))

<div data-slot="alert-dialog" data-state="closed"
    x-data="alertDialog(false, @json($dismissable))" x-modelable="open" x-bind="root" {{$rootAttributes}}>
    @isset($trigger)
    <div data-slot="alert-dialog-trigger" x-bind="trigger" {{$trigger->attributes}}>
        {{$trigger}}
    </div>
    @endisset

    @if ($attributes->has('x-teleport'))
    <template x-teleport="{{$attributes->get('x-teleport')}}">
    @endif
    <div data-slot="alert-dialog-overlay" role="presentation" class="fixed inset-0 z-50 bg-black/80"
        x-bind="overlay" x-cloak>
        @isset($content)
        <div data-slot="alert-dialog-content" role="alertdialog" x-bind="dialog"
            {{$content->attributes->twMerge(['fixed left-1/2 top-1/2 z-50 grid w-full max-w-lg -translate-x-1/2 -translate-y-1/2 gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg'])}}>
            {{$content}}
        </div>
        @endisset
    </div>
    @if ($attributes->has('x-teleport'))
    </template>
    @endif
</div>
