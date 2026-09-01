<april:sidebar-layout class="min-w-[64rem] flex-nowrap">
    <april:sidebar variant="floating" collapsible="icon">
        <slot:header>
            <april:dropdown-menu x-teleport="body" class="w-full">
                <slot:trigger>
                    <april:button variant="ghost" size="none"
                        class="h-10 w-full justify-between px-2 group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:justify-center group-data-[collapsible=icon]:px-0">
                        <span class="flex min-w-0 items-center gap-2">
                            <span
                                class="flex size-7 shrink-0 items-center justify-center rounded-md bg-primary text-primary-foreground">
                                <x-lucide-layers-3 class="size-4" />
                            </span>
                            <span class="truncate font-semibold group-data-[collapsible=icon]:hidden">Acme Inc.</span>
                        </span>
                        <x-lucide-chevrons-up-down class="size-4 shrink-0 group-data-[collapsible=icon]:hidden" />
                    </april:button>
                </slot:trigger>
                <slot:content>
                    <april:dropdown-menu-label>Switch workspace</april:dropdown-menu-label>
                    <april:dropdown-menu-separator />
                    <april:dropdown-menu-item>Acme Inc.
                        <april:dropdown-menu-shortcut>⌘1</april:dropdown-menu-shortcut></april:dropdown-menu-item>
                    <april:dropdown-menu-item>Design team
                        <april:dropdown-menu-shortcut>⌘2</april:dropdown-menu-shortcut></april:dropdown-menu-item>
                    <april:dropdown-menu-separator />
                    <april:dropdown-menu-item>Create workspace</april:dropdown-menu-item>
                </slot:content>
            </april:dropdown-menu>
            <april:sidebar-input class="mt-2 group-data-[collapsible=icon]:hidden" placeholder="Search..." />
        </slot:header>
        <slot:content>
            <april:sidebar-group>
                <april:sidebar-group-label>Workspace</april:sidebar-group-label>
                <april:sidebar-group-content>
                    <april:sidebar-menu>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#" :active="true">
                                <x-lucide-layout-dashboard />
                                <span>Overview</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-inbox />
                                <span>Inbox</span>
                                <april:sidebar-menu-badge>12</april:sidebar-menu-badge>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-calendar />
                                <span>Calendar</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-chart-line />
                                <span>Analytics</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-folder-kanban />
                                <span>Projects</span>
                                <april:sidebar-menu-badge>8</april:sidebar-menu-badge>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-users />
                                <span>Customers</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                    </april:sidebar-menu>
                </april:sidebar-group-content>
            </april:sidebar-group>
            <april:sidebar-group>
                <april:sidebar-group-label>Manage</april:sidebar-group-label>
                <april:sidebar-group-content>
                    <april:sidebar-menu>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-users />
                                <span>Team</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-settings />
                                <span>Settings</span>
                            </april:sidebar-menu-button-link>
                            <april:sidebar-menu-action :show-on-hover="true"
                                aria-label="Settings actions">•••</april:sidebar-menu-action>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-circle-help />
                                <span>Help center</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-list />
                                <span>Activity log</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                        <april:sidebar-menu-item>
                            <april:sidebar-menu-button-link href="#">
                                <x-lucide-sliders-horizontal />
                                <span>Preferences</span>
                            </april:sidebar-menu-button-link>
                        </april:sidebar-menu-item>
                    </april:sidebar-menu>
                </april:sidebar-group-content>
            </april:sidebar-group>
        </slot:content>
        <slot:footer>
            <april:dropdown-menu x-teleport="body" class="w-full">
                <slot:trigger>
                    <april:button variant="ghost" size="none"
                        class="h-10 w-full justify-start gap-2 px-2 group-data-[collapsible=icon]:size-8! group-data-[collapsible=icon]:justify-center">
                        <april:avatar size="sm">
                            <slot:fallback>PD</slot:fallback>
                        </april:avatar>
                        <span class="min-w-0 text-left group-data-[collapsible=icon]:hidden"><span
                                class="block truncate text-sm font-medium">Pedro Duarte</span><span
                                class="block truncate text-xs text-muted-foreground">pedro@example.com</span></span>
                    </april:button>
                </slot:trigger>
                <slot:content>
                    <april:dropdown-menu-label>My account</april:dropdown-menu-label>
                    <april:dropdown-menu-separator />
                    <april:dropdown-menu-item>Profile</april:dropdown-menu-item>
                    <april:dropdown-menu-item>Billing</april:dropdown-menu-item>
                    <april:dropdown-menu-item>Sign out</april:dropdown-menu-item>
                </slot:content>
            </april:dropdown-menu>
        </slot:footer>
        <april:sidebar-rail />
    </april:sidebar>
    <april:sidebar-inset>
        <header class="flex h-14 items-center justify-between border-b px-4">
            <div class="flex items-center gap-2">
                <april:sidebar-trigger />
                <span class="text-sm text-muted-foreground">Overview</span>
            </div>
            <april:button size="sm"><x-lucide-plus class="mr-2 size-4" />New project</april:button>
        </header>
        <main class="space-y-6 p-4 lg:p-6">
            <div>
                <h2 class="text-2xl font-semibold tracking-tight">Good morning, Pedro</h2>
                <p class="text-sm text-muted-foreground">Here is a summary of your workspace.</p>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <april:card>
                    <slot:title class="text-sm font-medium">Total revenue</slot:title>
                    <slot:content>
                        <div class="text-2xl font-bold">$45,231.89</div>
                        <p class="text-xs text-muted-foreground">+20.1% from last month</p>
                    </slot:content>
                </april:card>
                <april:card>
                    <slot:title class="text-sm font-medium">Subscriptions</slot:title>
                    <slot:content>
                        <div class="text-2xl font-bold">+2,350</div>
                        <p class="text-xs text-muted-foreground">+180.1% from last month</p>
                    </slot:content>
                </april:card>
                <april:card>
                    <slot:title class="text-sm font-medium">Sales</slot:title>
                    <slot:content>
                        <div class="text-2xl font-bold">+12,234</div>
                        <p class="text-xs text-muted-foreground">+19% from last month</p>
                    </slot:content>
                </april:card>
                <april:card>
                    <slot:title class="text-sm font-medium">Active now</slot:title>
                    <slot:content>
                        <div class="text-2xl font-bold">+573</div>
                        <p class="text-xs text-muted-foreground">+201 since last hour</p>
                    </slot:content>
                </april:card>
            </div>
        </main>
    </april:sidebar-inset>
</april:sidebar-layout>
