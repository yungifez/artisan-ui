<april:collapsible class="w-full max-w-md rounded-lg border p-4">
    <slot:trigger>
        <april:button variant="ghost" class="w-full justify-between">
            Project details
            <span aria-hidden="true">⌄</span>
        </april:button>
    </slot:trigger>
    <slot:content class="mt-4 space-y-2 text-sm text-muted-foreground">
        <p>April UI is a Blade component library inspired by shadcn/ui.</p>
        <p>This content expands and collapses without leaving the page.</p>
    </slot:content>
</april:collapsible>
