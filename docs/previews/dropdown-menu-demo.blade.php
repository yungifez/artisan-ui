<april:dropdown-menu>
    <slot:trigger>
        <april:button variant="outline">
            Open
        </april:button>
    </slot:trigger>
    <slot:content class="w-56">
        <april:dropdown-menu-label>
            My Account
        </april:dropdown-menu-label>
        <april:dropdown-menu-separator />
        <april:dropdown-menu-item>
            <x-lucide-user class="mr-2 h-4 w-4" />
            <span>Profile</span>
            <april:dropdown-menu-shortcut>⇧⌘P</april:dropdown-menu-shortcut>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <x-lucide-credit-card class="mr-2 h-4 w-4" />
            <span>Billing</span>
            <april:dropdown-menu-shortcut>⌘B</april:dropdown-menu-shortcut>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <x-lucide-settings class="mr-2 h-4 w-4" />
            <span>Settings</span>
            <april:dropdown-menu-shortcut>⌘S</april:dropdown-menu-shortcut>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <x-lucide-keyboard class="mr-2 h-4 w-4" />
            <span>Keyboard Shortcuts</span>
            <april:dropdown-menu-shortcut>⌘B</april:dropdown-menu-shortcut>
        </april:dropdown-menu-item>
        <april:dropdown-menu-separator />
        <april:dropdown-menu-item>
            <x-lucide-users class="mr-2 h-4 w-4" />
            <span>Team</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-sub>
            <slot:trigger>
                <x-lucide-user-plus class="mr-2 h-4 w-4" />
                <span>Invite User</span>
            </slot:trigger>
            <slot:content>
                <april:dropdown-menu-item>
                    <x-lucide-mail class="mr-2 h-4 w-4" />
                    <span>Email</span>
                </april:dropdown-menu-item>
                <april:dropdown-menu-item>
                    <x-lucide-message-circle class="mr-2 h-4 w-4" />
                    <span>Message</span>
                </april:dropdown-menu-item>
                <april:dropdown-menu-separator />
                <april:dropdown-menu-item>
                    <x-lucide-circle-plus class="mr-2 h-4 w-4" />
                    <span>More...</span>
                </april:dropdown-menu-item>
            </slot:content>
        </april:dropdown-menu-sub>
        <april:dropdown-menu-item>
            <x-lucide-plus class="mr-2 h-4 w-4" />
            <span>New Team</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-separator />
        <april:dropdown-menu-item>
            <x-lucide-github class="mr-2 h-4 w-4" />
            <span>Github</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <x-lucide-life-buoy class="mr-2 h-4 w-4" />
            <span>Support</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item disabled>
            <x-lucide-cloud class="mr-2 h-4 w-4" />
            <span>API</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <x-lucide-log-out class="mr-2 h-4 w-4" />
            <span>Log out</span>
        </april:dropdown-menu-item>
    </slot:content>
</april:dropdown-menu>
