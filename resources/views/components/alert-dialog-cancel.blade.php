<button type="button" data-slot="alert-dialog-cancel" x-bind="closeButton"
    {{$attributes->twMerge(['inline-flex h-10 items-center justify-center rounded-md border border-input bg-background px-4 py-2 text-sm font-medium transition-colors hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50'])}}>
    {{$slot}}
</button>
