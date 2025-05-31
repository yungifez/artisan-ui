@props(
[
'name' => '',
'labelClass' => '',
'errorBag' => 'default',
'errorName',
'oldName',
'label'
]
)

@php
$isInline = $attributes->get('inline') || in_array($attributes->get('type'), [ 'checkbox', 'radio', 'range']);
$errorName = $errorName ?? $name;
$oldName = $oldName ?? $name;
$displayErrors = $errors->$errorBag->has($errorName) && !$attributes->has("prevent-errors");
@endphp

<div @class(['flex-row w-fit items-center flex-wrap gap-2'=> $isInline, 'flex-col w-full' => !$isInline, " flex"])
    >
    @isset ($label)
    <label for="{{$attributes->get('id')}}" @if ($label instanceof Illuminate\View\ComponentSlot)
        {{$label->attributes->twMerge(['font-semibold', 'mx-2 cursor-pointer' => $isInline, 'my-2' =>
        !$isInline])}} @else @class(["font-semibold", 'mx-2 cursor-pointer' => $isInline, 'my-2' => !$isInline])
        @endif
        >
        {{$label}}
    </label>
    @endisset
    <input name="{{$name}}" {{$attributes->twMerge(["flex h-10 accent-foreground rounded-md border bg-background px-3
    py-2
    text-sm ring-offset-background file:border-0 file:bg-transparent file:text-muted-foreground file:text-sm
    file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2
    focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50", "border-input
    " => !$displayErrors, 'border-destructive' => $displayErrors, 'w-full' => !$isInline, 'w-fit' => $isInline])}}
    {{$attributes->whereDoesntStartWith(['label', 'group'])}}
    value="{{old($oldName) ?? $attributes->get('value')}}"
    >

    @if($displayErrors)
    @error($errorName, $errorBag)
    <p class="text-destructive text-sm mt-2 order-3 basis-full">{{$message}}</p>
    @enderror
    @endif
</div>
