<april:command class="rounded-lg border shadow-md w-[450px] m-auto">
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
