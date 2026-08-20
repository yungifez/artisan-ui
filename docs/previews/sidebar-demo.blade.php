<april:sidebar-layout class="min-h-[620px] border rounded-lg overflow-hidden">
    <april:sidebar collapsible="none" class="w-56 border-r">
        <april:sidebar-header>
            <span class="font-semibold px-2">Acme Inc</span>
        </april:sidebar-header>
        <april:sidebar-content>
            <april:sidebar-group>
                <april:sidebar-group-label>Platform</april:sidebar-group-label>
                <april:sidebar-group-content>
                    <april:sidebar-menu>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#" :active="true">Inbox</april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">Calendar</april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">Settings</april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                    </april:sidebar-menu>
                </april:sidebar-group-content>
            </april:sidebar-group>
        </april:sidebar-content>
        <april:sidebar-footer>
            <span class="text-sm text-muted-foreground px-2">Pedro Duarte</span>
        </april:sidebar-footer>
    </april:sidebar>
    <april:sidebar-inset class="p-4">
        <april:sidebar-trigger />
        <p class="mt-4 text-sm text-muted-foreground">Your page content goes here.</p>
    </april:sidebar-inset>
</april:sidebar-layout>
