{{--Font Awesome Icons used in example--}}
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
            <i class="fas fa-user mr-2 h-4 w-4"></i>
            <span>Profile</span>
            <april:dropdown-menu-shortcut>⇧⌘P</april:dropdown-menu-shortcut>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <i class="fas fa-credit-card mr-2 h-4 w-4"></i>
            <span>Billing</span>
            <april:dropdown-menu-shortcut>⌘B</april:dropdown-menu-shortcut>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <i class="fas fa-cog mr-2 h-4 w-4"></i>
            <span>Settings</span>
            <april:dropdown-menu-shortcut>⌘S</april:dropdown-menu-shortcut>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <i class="fas fa-keyboard mr-2 h-4 w-4"></i>
            <span>Keyboard Shortcuts</span>
            <april:dropdown-menu-shortcut>⌘B</april:dropdown-menu-shortcut>
        </april:dropdown-menu-item>
        <april:dropdown-menu-separator />
        <april:dropdown-menu-item>
            <i class="fas fa-users mr-2 h-4 w-4"></i>
            <span>Team</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-sub>
            <slot:trigger>
                <i class="fas fa-user-plus mr-2 h-4 w-4"></i>
                <span>Invite User</span>
            </slot:trigger>
            <slot:content>
                <april:dropdown-menu-item>
                    <i class="fas fa-envelope mr-2 h-4 w-4"></i>
                    <span>Email</span>
                </april:dropdown-menu-item>
                <april:dropdown-menu-item>
                    <i class="fas fa-message mr-2 h-4 w-4"></i>
                    <span>Message</span>
                </april:dropdown-menu-item>
                <april:dropdown-menu-separator />
                <april:dropdown-menu-item>
                    <i class="fas fa-plus-circle mr-2 h-4 w-4"></i>
                    <span>More...</span>
                </april:dropdown-menu-item>
            </slot:content>
        </april:dropdown-menu-sub>
        <april:dropdown-menu-item>
            <i class="fas fa-plus mr-2 h-4 w-4"></i>
            <span>New Team</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-separator />
        <april:dropdown-menu-item>
            <i class="fa-brands fa-github mr-2 h-4 w-4"></i>
            <span>Github</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <i class="fa fa-life-ring mr-2 h-4 w-4"></i>
            <span>Support</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item disabled>
            <i class="fa fa-cloud mr-2 h-4 w-4"></i>
            <span>API</span>
        </april:dropdown-menu-item>
        <april:dropdown-menu-item>
            <i class="fas fa-right-from-bracket mr-2 h-4 w-4"></i>
            <span>Log out</span>
        </april:dropdown-menu-item>
    </slot:content>
</april:dropdown-menu>
