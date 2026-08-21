<april:sidebar-layout class="min-h-[620px] border rounded-lg overflow-hidden">
    <april:sidebar-inset class="p-4">
        <april:sidebar-trigger />
        <p class="mt-4 text-sm text-muted-foreground">The sidebar sits on the right.</p>
    </april:sidebar-inset>
    <april:sidebar side="right">
        <slot:header>
            <span class="font-semibold px-2">Acme Inc</span>
        </slot:header>
        <slot:content>
            <april:sidebar-group>
                <april:sidebar-group-content>
                    <april:sidebar-menu>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">Inbox</april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                    </april:sidebar-menu>
                </april:sidebar-group-content>
            </april:sidebar-group>
        </slot:content>
        <april:sidebar-rail />
    </april:sidebar>
</april:sidebar-layout>
