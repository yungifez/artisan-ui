<april:data-table
    id="{{ $id }}"
    wire:key="{{ $id }}-{{ $this->tableRevision }}"
    :data="$data"
    :columns="$columns"
    :pagination="$pagination"
    :per-page-options="$perPageOptions"
    row-key="{{ $rowKey }}"
    :searchable="$searchable"
    :selectable="$selectable"
    @query-change="$wire.updateTable($event.detail)"
    @selection-change="$wire.updateSelection($event.detail.selected)"
/>
