<april:breadcrumb>
    <slot:list>
        <april:breadcrumb-item>
            <april:breadcrumb-link href="/">Home</april:breadcrumb-link>
        </april:breadcrumb-item>
        <april:breadcrumb-separator />
        <april:breadcrumb-item>
            <april:dropdown-menu>
                <slot:trigger class="flex items-center gap-1">
                    <april:breadcrumb-elipsis />
                    <span class="sr-only">Toggle menu</span>
                </slot:trigger>
                <slot:content align="start">
                    <april:dropdown-menu-item>Documentation</april:dropdown-menu-item>
                    <april:dropdown-menu-item>Themes</april:dropdown-menu-item>
                    <april:dropdown-menu-item>GitHub</april:dropdown-menu-item>
                </slot:content>
            </april:dropdown-menu>
        </april:breadcrumb-item>
        <april:breadcrumb-separator />
        <april:breadcrumb-item>
            <april:breadcrumb-link href="/docs/0.x/components/accordion">Components</april:breadcrumb-link>
        </april:breadcrumb-item>
        <april:breadcrumb-separator />
        <april:breadcrumb-item>
            <april:breadcrumb-page>Breadcrumb</april:breadcrumb-page>
        </april:breadcrumb-item>
    </slot:list>
</april:breadcrumb>
