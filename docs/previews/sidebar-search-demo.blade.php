<april:sidebar collapsible="none" class="w-64 border rounded-lg">
    <slot:header>
        <april:sidebar-input name="search" placeholder="Search the docs..." />
    </slot:header>
    <slot:content>
        <april:sidebar-group>
            <april:sidebar-group-content>
                <april:sidebar-menu>
                    <april:sidebar-menu-item>
                        <april:sidebar-menu-button-link href="#">Installation</april:sidebar-menu-button-link>
                    </april:sidebar-menu-item>
                    <april:sidebar-menu-item>
                        <april:sidebar-menu-button-link href="#">Theming</april:sidebar-menu-button-link>
                    </april:sidebar-menu-item>
                </april:sidebar-menu>
            </april:sidebar-group-content>
        </april:sidebar-group>
    </slot:content>
</april:sidebar>
