<april:popover x-teleport="body">
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
                    <april:label for="width-2">Width</april:label>
                    <april:input id="width-2" value="100%" class="col-span-2 h-8" />
                </div>
                <div class="grid grid-cols-3 items-center gap-4">
                    <april:label for="maxWidth-2">Max. width</april:label>
                    <april:input id="maxWidth-2" value="300px" class="col-span-2 h-8" />
                </div>
                <div class="grid grid-cols-3 items-center gap-4">
                    <april:label for="height-2">Height</april:label>
                    <april:input id="height-2" value="25px" class="col-span-2 h-8" />
                </div>
                <div class="grid grid-cols-3 items-center gap-4">
                    <april:label for="maxHeight-2">Max. height</april:label>
                    <april:input id="maxHeight-2" value="none" class="col-span-2 h-8" />
                </div>
            </div>
        </div>
    </slot:popover-content>
</april:popover>
