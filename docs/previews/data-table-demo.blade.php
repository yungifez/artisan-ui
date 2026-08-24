@php
    $team = [
        ['id' => 1, 'name' => 'Olivia Martin', 'email' => 'olivia@example.com', 'role' => 'Owner', 'status' => 'Active'],
        ['id' => 2, 'name' => 'Jackson Lee', 'email' => 'jackson@example.com', 'role' => 'Developer', 'status' => 'Active'],
        ['id' => 3, 'name' => 'Isabella Nguyen', 'email' => 'isabella@example.com', 'role' => 'Designer', 'status' => 'Invited'],
        ['id' => 4, 'name' => 'William Kim', 'email' => 'william@example.com', 'role' => 'Support', 'status' => 'Active'],
    ];

    $columns = [
        ['key' => 'name', 'label' => 'Name', 'sortable' => true],
        ['key' => 'email', 'label' => 'Email', 'sortable' => true],
        ['key' => 'role', 'label' => 'Role', 'sortable' => true],
        ['key' => 'status', 'label' => 'Status'],
    ];
@endphp

<april:data-table :data="$team" :columns="$columns" searchable selectable paginated :per-page="3">
    <slot:caption>A list of your team members and their roles.</slot:caption>
    <slot:cell-status>
        <span class="rounded-full bg-emerald-500/15 px-2 py-1 text-xs font-medium text-emerald-700 dark:text-emerald-300" x-text="row.status"></span>
    </slot:cell-status>
    <slot:actions>
        <april:button size="sm" variant="ghost" x-text="`Edit ${row.name}`"></april:button>
    </slot:actions>
</april:data-table>
