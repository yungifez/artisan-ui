<april:attachment-group class="max-w-xl">
    <april:attachment class="min-w-[280px]" state="done">
        <slot:media><x-lucide-file-text class="text-muted-foreground" /></slot:media>
        <slot:content>
            <p class="truncate font-medium">project-brief.pdf</p>
            <p class="text-sm text-muted-foreground">PDF · 2.4 MB</p>
        </slot:content>
        <slot:actions>
            <april:attachment-action aria-label="Remove project brief">
                <x-lucide-x class="size-4" />
            </april:attachment-action>
        </slot:actions>
    </april:attachment>
    <april:attachment class="min-w-[280px]" state="uploading">
        <slot:media><x-lucide-file-up class="text-muted-foreground" /></slot:media>
        <slot:content>
            <p class="truncate font-medium">design-assets.zip</p>
            <p class="text-sm text-muted-foreground">Uploading · 64%</p>
        </slot:content>
    </april:attachment>
</april:attachment-group>
