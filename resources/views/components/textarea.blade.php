@props(
    [
        'id' => '',
        'name' => '',
        'label' => '',
        'value' => null,
        'class' => '',
        'groupClass' => 'my-3',
        'labelClass' => '',
        'errorBag' => 'default',
        'errorName',
        'displayErrors' => "true",
        'oldName' => '',

        'color' => 'bg-[color:var(--textarea-bg-color)] dark:bg-[color:var(--textarea-dark-bg-color)] text-[color:var(--textarea-text-color)] dark:text-[color:var(--textarea-dark-text-color)] border-[color:var(--textarea-border-color)] dark:border-[color:var(--textarea-dark-border-color)] file:bg-[color:var(--textarea-file-bg-color)] dark:file:bg-[color:var(--textarea-dark-file-bg-color)] file:text-[color:var(--textarea-file-text-color)] dark:file:text-[color:var(--textarea-dark-file-text-color)] placeholder-[color:var(--textarea-placeholder-color)] dark:placeholder-[var(--textarea-dark-placeholder-color)] focus:ring-[var(--textarea-accent-color)] dark:focus:ring-[color:var(--textarea-dark-accent-color)]',
        'labelColor' => 'text-[var(--textarea-text-color)] dark:text-[var(--textarea-dark-text-color)]',

        'defaultClass' => 'flex py-3 px-4 rounded-md border border-input px-3 py-1 text-sm shadow-sm transition-colors file:border-0  file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50'
    ]
)

@php
    $errorName = $errorName ?? $name;
    $oldName = $oldName ?? $name;
@endphp

<div @class(["$groupClass flex flex-col my-2"])>
    @if (!empty($label))
        <label for="{{$id}}" @class(["$labelClass font-semibold text-gray-700 cursor-pointer my-2 dark:text-gray-200"]) {{$attributes->whereStartsWith("label")}}>{{$label}}</label>
    @endif
    <textarea id="{{$id}}" name="{{$name}}" @class(["$color $class $defaultClass", 'border-[var(--textarea-error-border-color)] dark:border-[var(--textarea-dark-error-border-color)] ' => $errors->has($errorName)]) {{$attributes->whereDoesntStartWith(['label'])}}>{{old($oldName) ?? ($slot != null ? $slot : '')}}</textarea>
    @if( $displayErrors && $displayErrors != "false")
        @error($errorName, $errorBag)
            <p class="text-[var(--textarea-error-text-color)] dark:text-[var(--textarea-dark-error-text-color)]  my-1 order-3 basis-full">{{$message}}</p>
        @enderror
    @endif
</div>
