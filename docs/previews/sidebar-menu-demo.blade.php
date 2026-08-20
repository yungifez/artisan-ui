<april:sidebar collapsible="none" class="w-64 border rounded-lg">
    <april:sidebar-content>
        <april:sidebar-group>
            <april:sidebar-group-label>Projects</april:sidebar-group-label>
            <april:sidebar-group-action>+</april:sidebar-group-action>
            <april:sidebar-group-content>
                <april:sidebar-menu>
                    <april:sidebar-menu-item>
                        <april:sidebar-menu-button-link href="#" :active="true">Design system</april:sidebar-menu-button-link>
                        <april:sidebar-menu-badge>24</april:sidebar-menu-badge>
                    </april:sidebar-menu-item>
                    <april:sidebar-menu-item>
                        <april:sidebar-menu-button-link href="#">Marketing site</april:sidebar-menu-button-link>
                        <april:sidebar-menu-action :show-on-hover="true">...</april:sidebar-menu-action>
                        <april:sidebar-menu-sub>
                            <april:sidebar-menu-sub-item>
                                <april:sidebar-menu-sub-button href="#">Landing page</april:sidebar-menu-sub-button>
                            </april:sidebar-menu-sub-item>
                            <april:sidebar-menu-sub-item>
                                <april:sidebar-menu-sub-button href="#" :active="true">Pricing</april:sidebar-menu-sub-button>
                            </april:sidebar-menu-sub-item>
                        </april:sidebar-menu-sub>
                    </april:sidebar-menu-item>
                    <april:sidebar-separator />
                    <april:sidebar-menu-item>
                        <april:sidebar-menu-skeleton :show-icon="true" />
                    </april:sidebar-menu-item>
                </april:sidebar-menu>
            </april:sidebar-group-content>
        </april:sidebar-group>
    </april:sidebar-content>
</april:sidebar>
