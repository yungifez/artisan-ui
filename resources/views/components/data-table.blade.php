@props([
    'caption' => null,
    'data' => null,
    'columns' => [],
    'searchable' => false,
    'selectable' => false,
    'paginated' => false,
    'perPage' => 10,
    'perPageOptions' => [10, 20, 50],
    'rowKey' => 'id',
    'pagination' => null,
])

@php
    $isInteractive = is_countable($columns) && count($columns) > 0;
    $hasPagination = is_array($pagination);
    $options = [
        'searchable' => (bool) $searchable,
        'selectable' => (bool) $selectable,
        'paginated' => (bool) ($paginated || $hasPagination),
        'perPage' => (int) $perPage,
        'perPageOptions' => $perPageOptions,
        'rowKey' => $rowKey,
        'pagination' => $pagination,
        'id' => $attributes->get('id', ''),
    ];
@endphp

@if ($isInteractive)
    <div data-slot="data-table"
        x-data="dataTable({{ \Illuminate\Support\Js::from($data ?? []) }}, {{ \Illuminate\Support\Js::from($columns) }}, {{ \Illuminate\Support\Js::from($options) }})"
        x-bind="root"
        {{$attributes->twMerge(['w-full'])}}>
        @if ($searchable)
            <div data-slot="data-table-toolbar" class="mb-4 flex items-center justify-between gap-3">
                <input type="search" x-model.debounce.250ms="search" placeholder="Search rows..." aria-label="Search rows"
                    class="flex h-9 w-full max-w-sm rounded-md border border-input bg-background px-3 py-1 text-sm shadow-xs outline-none placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                @isset($toolbar)
                    {{$toolbar}}
                @endisset
            </div>
        @endif

        <div class="relative w-full overflow-auto rounded-md border">
            <table class="w-full caption-bottom text-sm">
                @isset($caption)
                    <caption data-slot="data-table-caption" class="mt-4 text-sm text-muted-foreground">{{$caption}}</caption>
                @endisset
                <thead data-slot="data-table-header" class="border-b bg-muted/50">
                    <tr>
                        @if ($selectable)
                            <th scope="col" class="h-10 w-12 px-4 text-left align-middle">
                                <input type="checkbox" :checked="allVisibleSelected" @change="toggleVisibleRows()" aria-label="Select visible rows"
                                    class="size-4 rounded-sm border-input accent-primary">
                            </th>
                        @endif
                        @foreach ($columns as $column)
                            @php
                                $key = $column['key'] ?? '';
                                $label = $column['label'] ?? $key;
                                $sortable = (bool) ($column['sortable'] ?? false);
                            @endphp
                            <th scope="col" :aria-sort="sortState(@js($key))" @class([
                                'h-10 px-4 text-left align-middle font-medium text-muted-foreground',
                                'text-right' => ($column['align'] ?? '') === 'right',
                                'text-center' => ($column['align'] ?? '') === 'center',
                            ])>
                                @if ($sortable)
                                    <button type="button" @click="toggleSort(@js($key))"
                                        class="-ml-2 inline-flex h-8 items-center gap-1 rounded-md px-2 hover:bg-accent hover:text-accent-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                                        <span>{{ $label }}</span><span aria-hidden="true" class="text-muted-foreground" x-text="sortIndicator(@js($key))"></span>
                                    </button>
                                @else
                                    {{ $label }}
                                @endif
                            </th>
                        @endforeach
                        @isset($actions)
                            <th scope="col" class="h-10 px-4 text-right align-middle font-medium text-muted-foreground"><span class="sr-only">Actions</span></th>
                        @endisset
                    </tr>
                </thead>
                <tbody data-slot="data-table-body" class="divide-y">
                    <template x-for="row in visibleRows" :key="rowDomKey(row)">
                        <tr data-slot="data-table-row" :data-state="isSelected(row) ? 'selected' : null"
                            :class="{ 'bg-muted/50': isSelected(row) }" class="border-b transition-colors hover:bg-muted/50 last:border-0">
                            @if ($selectable)
                                <td data-slot="data-table-cell" class="w-12 p-4 align-middle">
                                    <input type="checkbox" :checked="isSelected(row)" @change="toggleRow(row)" :aria-label="`Select ${rowDomKey(row)}`"
                                        class="size-4 rounded-sm border-input accent-primary">
                                </td>
                            @endif
                            @foreach ($columns as $column)
                                @php
                                    $key = $column['key'] ?? '';
                                    $slotName = 'cell'.\Illuminate\Support\Str::studly($key);
                                    $cellSlot = isset($$slotName) ? $$slotName : null;
                                @endphp
                                <td data-slot="data-table-cell" @class([
                                    'p-4 align-middle',
                                    'text-right' => ($column['align'] ?? '') === 'right',
                                    'text-center' => ($column['align'] ?? '') === 'center',
                                ])>
                                    @if ($cellSlot)
                                        {{$cellSlot}}
                                    @else
                                        <span x-text="display(row, @js($key))"></span>
                                    @endif
                                </td>
                            @endforeach
                            @isset($actions)
                                <td data-slot="data-table-cell" class="p-4 text-right align-middle">{{$actions}}</td>
                            @endisset
                        </tr>
                    </template>
                    <tr x-show="visibleRows.length === 0">
                        <td :colspan="columns.length + (selectable ? 1 : 0) + {{ isset($actions) ? 1 : 0 }}" class="h-24 p-4 text-center text-muted-foreground">
                            @isset($empty)
                                {{$empty}}
                            @else
                                No results found.
                            @endisset
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if ($paginated || $hasPagination)
            <div data-slot="data-table-pagination" class="mt-4 flex flex-col gap-3 text-sm text-muted-foreground sm:flex-row sm:items-center sm:justify-between">
                <p><span x-text="pageStart"></span>–<span x-text="pageEnd"></span> of <span x-text="totalRows"></span> rows</p>
                <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center">
                    <label class="flex items-center justify-between gap-2 sm:justify-start">Rows per page
                        <select @change="setPerPage($event.target.value)" :value="perPage" class="h-8 min-w-0 rounded-md border border-input bg-background px-2 text-foreground">
                            <template x-for="option in perPageOptions" :key="option"><option :value="option" x-text="option"></option></template>
                        </select>
                    </label>
                    <div class="flex items-center justify-between gap-2 sm:justify-start">
                        <button type="button" @click="setPage(page - 1)" :disabled="page <= 1" aria-label="Previous page"
                            class="inline-flex h-8 shrink-0 items-center rounded-md border border-input bg-background px-3 text-foreground disabled:pointer-events-none disabled:opacity-50 hover:bg-accent">Previous</button>
                        <span class="tabular-nums"><span x-text="Math.min(page, totalPages)"></span> / <span x-text="totalPages"></span></span>
                        <button type="button" @click="setPage(page + 1)" :disabled="page >= totalPages" aria-label="Next page"
                            class="inline-flex h-8 shrink-0 items-center rounded-md border border-input bg-background px-3 text-foreground disabled:pointer-events-none disabled:opacity-50 hover:bg-accent">Next</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
@else
    <div data-slot="data-table" {{$attributes->twMerge(['w-full'])}}>
        <div class="relative w-full overflow-auto rounded-md border">
            <table class="w-full caption-bottom text-sm">
                @isset($caption)
                    <caption data-slot="data-table-caption" class="mt-4 text-sm text-muted-foreground">{{$caption}}</caption>
                @endisset
                @isset($header)
                    <thead data-slot="data-table-header" class="border-b bg-muted/50">
                        {{$header}}
                    </thead>
                @endisset
                @isset($body)
                    <tbody data-slot="data-table-body" class="divide-y">
                        {{$body}}
                    </tbody>
                @endisset
            </table>
        </div>
    </div>
@endif
