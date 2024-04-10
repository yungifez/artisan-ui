@props(
    [
        'name' => '',
        'groupClass' => 'my-3',
        'errorBag' => 'default',
        'errorName',
        'oldName',
    ]
)

@php
    $errorName = $errorName ?? $name;
    $oldName = $oldName ?? $name;
    $displayErrors = $errors->$errorBag->has($errorName) && !$attributes->has("prevent-errors");
@endphp

<div @class(["$groupClass flex flex-col my-2"])>

    @if ($attributes->has('label'))
        <label
            for="{{$attributes->get('id')}}"
            @class(["font-semibold my-2"])
            {{$attributes->whereStartsWith("label")}}
        >
            {{$attributes->get('label')}}
        </label>
    @endif

    <select
        name="{{$name}}"
        {{$attributes->class(["flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50", 'border-destructive' => $displayErrors])}}
    >
        {{$slot}}
    </select>
    @if($displayErrors)
        @error($errorName, $errorBag)
            <p class="text-destructive text-sm mt-2 order-3 basis-full">{{$message}}</p>
        @enderror
    @endif
</div>
