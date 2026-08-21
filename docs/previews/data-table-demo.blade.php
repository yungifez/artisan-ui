<april:data-table>
    <slot:caption>A list of your team members and their roles.</slot:caption>
    <slot:header>
        <april:data-table-row>
            <april:data-table-head>Name</april:data-table-head>
            <april:data-table-head>Email</april:data-table-head>
            <april:data-table-head>Role</april:data-table-head>
            <april:data-table-head class="text-right">Status</april:data-table-head>
        </april:data-table-row>
    </slot:header>
    <slot:body>
        <april:data-table-row>
            <april:data-table-cell class="font-medium">Olivia Martin</april:data-table-cell>
            <april:data-table-cell>olivia@example.com</april:data-table-cell>
            <april:data-table-cell>Owner</april:data-table-cell>
            <april:data-table-cell class="text-right"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">Active</span></april:data-table-cell>
        </april:data-table-row>
        <april:data-table-row>
            <april:data-table-cell class="font-medium">Jackson Lee</april:data-table-cell>
            <april:data-table-cell>jackson@example.com</april:data-table-cell>
            <april:data-table-cell>Developer</april:data-table-cell>
            <april:data-table-cell class="text-right"><span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-medium text-emerald-700">Active</span></april:data-table-cell>
        </april:data-table-row>
        <april:data-table-row>
            <april:data-table-cell class="font-medium">Isabella Nguyen</april:data-table-cell>
            <april:data-table-cell>isabella@example.com</april:data-table-cell>
            <april:data-table-cell>Designer</april:data-table-cell>
            <april:data-table-cell class="text-right"><span class="rounded-full bg-muted px-2 py-1 text-xs font-medium text-muted-foreground">Invited</span></april:data-table-cell>
        </april:data-table-row>
    </slot:body>
</april:data-table>
