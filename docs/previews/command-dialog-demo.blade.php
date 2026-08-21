<div x-data="{showDialog: false}">
    <p @keydown.window.ctrl.j.prevent="showDialog = true" class="hidden lg:block text-sm text-muted-foreground">
        Press
        <kbd
            class="pointer-events-none inline-flex h-5 select-none items-center gap-1 rounded border bg-muted px-1.5 font-mono text-[10px] font-medium text-muted-foreground opacity-100">
            <span class="text-xs">⌘</span>J
        </kbd>
    </p>
    <april:command-dialog x-teleport="body" x-model="showDialog">
        <slot:trigger>
            <april:button variant="outline" class="lg:hidden">Open</april:button>
        </slot:trigger>
        <april:command>
            <slot:input placeholder="Type a command or search..."></slot:input>
            <slot:empty>No results found.</slot:empty>
            <slot:list>
                <april:command-group heading="Suggestions">
                    <april:command-item>
                        <x-lucide-calendar class="size-4" />
                        <span>Calendar</span>
                    </april:command-item>
                    <april:command-item>
                        <x-lucide-smile class="size-4" />
                        <span>Search Emoji</span>
                    </april:command-item>
                    <april:command-item disabled>
                        <x-lucide-calculator class="size-4" />
                        <span>Calculator</span>
                    </april:command-item>

                </april:command-group>
                <april:command-separator />
                <april:command-group heading="Settings">
                    <april:command-item>
                        <x-lucide-user class="size-4" />
                        <span>Profile</span>
                        <april:command-shortcut>⌘P</april:command-shortcut>
                    </april:command-item>
                    <april:command-item>
                        <x-lucide-credit-card class="size-4" />
                        <span>Billing</span>
                        <april:command-shortcut>⌘B</april:command-shortcut>
                    </april:command-item>
                    <april:command-item>
                        <x-lucide-settings class="size-4" />
                        <span>Settings</span>
                        <april:command-shortcut>⌘S</april:command-shortcut>
                    </april:command-item>
                </april:command-group>
            </slot:list>
        </april:command>
    </april:command-dialog>
</div>
