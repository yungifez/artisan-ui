<april:collapsible class="flex w-full max-w-md flex-col gap-2 rounded-lg border p-4">
    <slot:trigger>
        <div class="flex items-center justify-between gap-4 px-4">
            <h4 class="text-sm font-semibold">Order #4189</h4>
            <april:button variant="ghost" size="icon" class="size-8" aria-label="Toggle details">
                <x-lucide-chevrons-up-down class="size-4" />
            </april:button>
        </div>
        <div class="flex items-center justify-between rounded-md border px-4 py-2 text-sm">
            <span class="text-muted-foreground">Status</span>
            <span class="font-medium">Shipped</span>
        </div>
    </slot:trigger>
    <slot:content class="flex flex-col gap-2">
        <div class="rounded-md border px-4 py-2 text-sm">
            <p class="font-medium">Shipping address</p>
            <p class="text-muted-foreground">100 Market St, San Francisco</p>
        </div>
        <div class="rounded-md border px-4 py-2 text-sm">
            <p class="font-medium">Items</p>
            <p class="text-muted-foreground">2x Studio Headphones</p>
        </div>
    </slot:content>
</april:collapsible>
