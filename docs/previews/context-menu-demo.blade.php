<april:context-menu>
    <div class="flex min-h-32 max-w-md items-center justify-center rounded-lg border border-dashed text-sm text-muted-foreground">
        Right-click this area
    </div>
    <slot:content class="w-48">
        <april:context-menu-label>Actions</april:context-menu-label>
        <april:context-menu-separator />
        <april:context-menu-item>
            <x-lucide-copy class="mr-2 size-4" /> Copy
        </april:context-menu-item>
        <april:context-menu-item>
            <x-lucide-pencil class="mr-2 size-4" /> Rename
        </april:context-menu-item>
        <april:context-menu-separator />
        <april:context-menu-item class="text-destructive">
            <x-lucide-trash-2 class="mr-2 size-4" /> Delete
        </april:context-menu-item>
    </slot:content>
</april:context-menu>
