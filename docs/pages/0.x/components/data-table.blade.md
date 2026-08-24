---
view: components.docs-layout
title: Data Table
description: A client-side Alpine data table with sorting, search, selection, pagination, and custom cells.
---

<x-component-preview component="previews.data-table-demo"></x-component-preview>

Pass row data and column definitions to enable the interactive table. It supports sorting, full-table search, row selection, pagination, an empty state, and `query-change` / `selection-change` events for a future server or Livewire integration.

<x-code-block-wrapper language="blade">
@verbatim
@php
    $columns = [
        ['key' => 'name', 'label' => 'Name', 'sortable' => true],
        ['key' => 'email', 'label' => 'Email', 'sortable' => true],
        ['key' => 'status', 'label' => 'Status'],
    ];
@endphp

<april:data-table :data="$users" :columns="$columns" searchable selectable paginated>
    <slot:cell-status>
        <april:badge variant="secondary" x-text="row.status" />
    </slot:cell-status>

    <slot:actions>
        <april:button size="sm" variant="ghost" x-text="`Edit ${row.name}`" />
    </slot:actions>
</april:data-table>
@endverbatim
</x-code-block-wrapper>

Columns accept `key`, `label`, `sortable`, `searchable`, and `align` (`left`, `center`, or `right`). Use a `cell-{key}` slot to render a custom cell; the Alpine `row` object is available in that slot. The original header/body slot composition remains available when you do not pass `columns`.

## Controlled data

Pass `pagination` with `mode: controlled` when another system owns the query. April displays the supplied page and emits `query-change`; it does not assume Livewire, an API client, or a backend transport. Send a `data-table:sync` browser event with `{ id, data, pagination }` to replace the visible page without remounting the component.

## Livewire adapter

The optional Livewire adapter ships inside `yungifez/april-ui`; install it alongside Livewire with `composer require yungifez/april-ui livewire/livewire`. It adds the familiar `builder()` and `columns()` class pattern, owns the Eloquent query, pagination, URL state, and bridges to this controlled mode while the base April component remains usable without Livewire.

```php
final class UsersTable extends DataTableComponent
{
    protected function builder(): Builder
    {
        return User::query();
    }

    protected function columns(): array
    {
        return [
            Column::make('Name', 'name')->searchable()->sortable(),
            Column::make('Email', 'email')->searchable()->sortable(),
        ];
    }
}
```

Render the adapter with `<livewire:users-table />`.

<x-publish-command :views="['data-table', 'data-table-row', 'data-table-head', 'data-table-cell']" />
