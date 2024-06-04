@props(
[
'name' => '',
'errorBag' => 'default',
'errorName',
'oldName',
'label'
]
)

@php
$errorName = $errorName ?? $name;
$oldName = $oldName ?? $name;
$displayErrors = $errors->$errorBag->has($errorName) && !$attributes->has("prevent-errors");
@endphp

<div @class([" flex flex-col my-2"])>

    @isset ($label)
    <label for="{{$attributes->get('id')}}" @if ($label instanceof Illuminate\View\ComponentSlot)
        {{$label->attributes->class(['font-semibold my-2'])}} @else class="font-semibold my-2" @endif
        >
        {{$label}}
    </label>
    @endisset

    <textarea name="{{$name}}" {{$attributes->class(["flex min-h-[80px] w-full rounded-md border bg-background px-3 py-2
        text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2
        focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed
        disabled:opacity-50","border-input " => !$displayErrors, 'border-destructive' =>
        $displayErrors])}}>@if(!is_null(old($oldName))){{old($oldName)}}@else{{$slot}}@endif</textarea>
    @if($displayErrors)
    @error($errorName, $errorBag)
    <p class="text-destructive text-sm mt-2 order-3 basis-full">{{$message}}</p>
    @enderror
    @endif
</div>
