<april:popover>
    <slot:trigger>
        <april:button variant="outline">Open popover</april:button>
    </slot:trigger>
    <slot:popover-content class="w-80">
        <div class="grid gap-4">
            <div class="space-y-2">
                <h4 class="font-medium leading-none">Dimensions</h4>
                <p class="text-sm text-muted-foreground">
                    Set the dimensions for the layer.
                </p>
            </div>
            <div class="grid gap-2">
                <div class="grid grid-cols-3 items-center gap-4">
                    <april:label for="width">Width</april:label>
                    <april:input id="width" value="100%" class="col-span-2 h-8" />
                </div>
                <div class="grid grid-cols-3 items-center gap-4">
                    <april:label for="maxWidth">Max. width</april:label>
                    <april:input id="maxWidth" value="300px" class="col-span-2 h-8" />
                </div>
                <div class="grid grid-cols-3 items-center gap-4">
                    <april:label for="height">Height</april:label>
                    <april:input id="height" value="25px" class="col-span-2 h-8" />
                </div>
                <div class="grid grid-cols-3 items-center gap-4">
                    <april:label for="maxHeight">Max. height</april:label>
                    <april:input id="maxHeight" value="none" class="col-span-2 h-8" />
                </div>
            </div>
        </div>
    </slot:popover-content>
</april:popover>
