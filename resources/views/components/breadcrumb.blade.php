@props(['list'])
<nav aria-label="breadcrumb" {{$attributes}}>
    @isset($list)
    <ol {{$attributes->twMerge('flex flex-wrap items-center gap-1.5 break-words text-sm text-muted-foreground
        sm:gap-2.5')}}>
        {{$list}}
    </ol>
    @endisset
</nav>
