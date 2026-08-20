<april:breadcrumb>
    <slot:list>
        <april:breadcrumb-item>
            <april:breadcrumb-link href="/">Home</april:breadcrumb-link>
        </april:breadcrumb-item>
        <april:breadcrumb-separator>
            <slot:separator>
                /
            </slot:separator>
        </april:breadcrumb-separator>
        <april:breadcrumb-item>
            <april:dropdown-menu>
                <slot:trigger>
                    <button class="bg-transparent cursor-pointer flex items-center gap-1">
                        Components
                        <i class="fas fa-angle-down"></i>
                    </button>
                </slot:trigger>
                <slot:content align="start">
                    <april:dropdown-menu-item>Documentation</april:dropdown-menu-item>
                    <april:dropdown-menu-item>Themes</april:dropdown-menu-item>
                    <april:dropdown-menu-item>GitHub</april:dropdown-menu-item>
                </slot:content>
            </april:dropdown-menu>
        </april:breadcrumb-item>
        <april:breadcrumb-separator>
            <slot:separator>
                /
            </slot:separator>
        </april:breadcrumb-separator>
        <april:breadcrumb-item>
            <april:breadcrumb-page>Breadcrumb</april:breadcrumb-page>
        </april:breadcrumb-item>
    </slot:list>
</april:breadcrumb>
