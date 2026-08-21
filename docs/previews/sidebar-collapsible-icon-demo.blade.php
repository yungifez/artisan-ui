<april:sidebar-layout class="min-h-[620px] border rounded-lg overflow-hidden">
    <april:sidebar collapsible="icon">
        <slot:header>
            <span class="font-semibold px-2">Acme Inc</span>
        </slot:header>
        <slot:content>
            <april:sidebar-group>
                <april:sidebar-group-label>Platform</april:sidebar-group-label>
                <april:sidebar-group-content>
                    <april:sidebar-menu>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#" :active="true">
                                <x-lucide-inbox />
                                <span>Inbox</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-calendar />
                                <span>Calendar</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                    </april:sidebar-menu>
                </april:sidebar-group-content>
            </april:sidebar-group>
        </slot:content>
        <april:sidebar-rail />
    </april:sidebar>
    <april:sidebar-inset class="p-4">
        <april:sidebar-trigger />
        <p class="mt-4 text-sm text-muted-foreground">Collapse the sidebar to see it shrink to icon width.</p>
    </april:sidebar-inset>
</april:sidebar-layout>
