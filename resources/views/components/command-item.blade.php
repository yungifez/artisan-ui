@props(['disabled' => false])
<div {{$attributes->twMerge(["relative flex cursor-default gap-2 select-none items-center rounded-sm px-2 py-1.5 text-sm
    outline-none data-[disabled=true]:pointer-events-none data-[selected='true']:bg-accent
    data-[selected=true]:text-accent-foreground data-[disabled=true]:opacity-50 [&amp;_svg]:pointer-events-none
    [&amp;_svg]:size-4 [&amp;_svg]:shrink-0"])}}
    role="option" x-bind="commandItem" data-disabled="@json($disabled)" cmd-item>
    {{$slot}}
</div>
