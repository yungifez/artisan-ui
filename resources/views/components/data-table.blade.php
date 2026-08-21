@props([
    'caption' => null,
])

<div data-slot="data-table" {{$attributes->twMerge(['w-full'])}}>
    <div class="relative w-full overflow-auto rounded-md border">
        <table class="w-full caption-bottom text-sm">
            @isset($caption)
                <caption data-slot="data-table-caption" class="mt-4 text-sm text-muted-foreground">{{$caption}}</caption>
            @endisset
            @isset($header)
                <thead data-slot="data-table-header" class="border-b bg-muted/50">
                    {{$header}}
                </thead>
            @endisset
            @isset($body)
                <tbody data-slot="data-table-body" class="divide-y">
                    {{$body}}
                </tbody>
            @endisset
        </table>
    </div>
</div>
