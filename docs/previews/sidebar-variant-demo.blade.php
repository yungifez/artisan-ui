<april:sidebar-layout class="min-h-[620px] border rounded-lg overflow-hidden">
    <april:sidebar variant="floating" collapsible="icon">
        <april:sidebar-header>
            <span class="font-semibold px-2">Acme Inc</span>
        </april:sidebar-header>
        <april:sidebar-content>
            <april:sidebar-group>
                <april:sidebar-group-content>
                    <april:sidebar-menu>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#" :active="true">Inbox</april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                    </april:sidebar-menu>
                </april:sidebar-group-content>
            </april:sidebar-group>
        </april:sidebar-content>
    </april:sidebar>
    <april:sidebar-inset class="p-4">
        <april:sidebar-trigger />
        <p class="mt-4 text-sm text-muted-foreground">The floating variant rounds the panel and adds a border.</p>
    </april:sidebar-inset>
</april:sidebar-layout>
