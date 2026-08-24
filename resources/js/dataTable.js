const normalize = (value) => String(value ?? '').toLocaleLowerCase();

const number = (value) => Number(value);

export default (data = [], columns = [], options = {}) => ({
    data: Array.isArray(data) ? data : [],
    columns: Array.isArray(columns) ? columns : [],
    controlled: options.pagination?.mode === 'controlled',
    tableId: options.id || '',
    searchable: Boolean(options.searchable),
    selectable: Boolean(options.selectable),
    paginated: Boolean(options.paginated || options.pagination),
    rowKey: options.rowKey || 'id',
    perPage: Math.max(1, number(options.pagination?.perPage ?? options.perPage) || 10),
    perPageOptions: [...new Set([...(Array.isArray(options.perPageOptions) ? options.perPageOptions : [10, 20, 50]), number(options.pagination?.perPage ?? options.perPage) || 10])],
    total: Math.max(0, number(options.pagination?.total)),
    search: options.pagination?.search || '',
    page: Math.max(1, number(options.pagination?.page) || 1),
    sortKey: options.pagination?.sort?.key || null,
    sortDirection: options.pagination?.sort?.direction === 'desc' ? 'desc' : 'asc',
    selected: [],

    init() {
        this.$watch('search', () => {
            this.page = 1;
            this.emitQueryChange();
        });
    },

    get filteredRows() {
        if (this.controlled) {
            return this.data;
        }

        const query = normalize(this.search).trim();

        if (! query || ! this.searchable) {
            return this.data;
        }

        const keys = this.columns
            .filter((column) => column.searchable !== false)
            .map((column) => column.key);

        return this.data.filter((row) => keys.some((key) => normalize(this.value(row, key)).includes(query)));
    },

    get sortedRows() {
        if (this.controlled) {
            return this.filteredRows;
        }

        if (! this.sortKey) {
            return this.filteredRows;
        }

        return [...this.filteredRows].sort((left, right) => {
            const leftValue = this.value(left, this.sortKey);
            const rightValue = this.value(right, this.sortKey);
            const leftNumber = number(leftValue);
            const rightNumber = number(rightValue);
            let comparison;

            if (Number.isFinite(leftNumber) && Number.isFinite(rightNumber)) {
                comparison = leftNumber - rightNumber;
            } else {
                comparison = String(leftValue ?? '').localeCompare(String(rightValue ?? ''), undefined, {
                    numeric: true,
                    sensitivity: 'base',
                });
            }

            return this.sortDirection === 'asc' ? comparison : -comparison;
        });
    },

    get totalPages() {
        return Math.max(1, Math.ceil(this.totalRows / this.perPage));
    },

    get totalRows() {
        return this.controlled ? this.total : this.sortedRows.length;
    },

    get visibleRows() {
        if (this.controlled) {
            return this.data;
        }

        if (! this.paginated) {
            return this.sortedRows;
        }

        const page = Math.min(this.page, this.totalPages);
        const offset = (page - 1) * this.perPage;

        return this.sortedRows.slice(offset, offset + this.perPage);
    },

    get pageStart() {
        return this.totalRows ? ((Math.min(this.page, this.totalPages) - 1) * this.perPage) + 1 : 0;
    },

    get pageEnd() {
        if (this.controlled) {
            return this.data.length
                ? Math.min(this.pageStart + this.data.length - 1, this.totalRows)
                : 0;
        }

        return Math.min(this.pageStart + this.perPage - 1, this.totalRows);
    },

    value(row, key) {
        return String(key ?? '').split('.').reduce((value, segment) => value?.[segment], row);
    },

    display(row, key) {
        const value = this.value(row, key);

        return value == null ? '' : String(value);
    },

    identity(row) {
        const value = this.value(row, this.rowKey);

        return String(value ?? this.data.indexOf(row));
    },

    rowDomKey(row) {
        return this.identity(row);
    },

    isSelected(row) {
        return this.selected.includes(this.identity(row));
    },

    get allVisibleSelected() {
        return this.visibleRows.length > 0 && this.visibleRows.every((row) => this.isSelected(row));
    },

    toggleRow(row) {
        const id = this.identity(row);

        this.selected = this.selected.includes(id)
            ? this.selected.filter((selected) => selected !== id)
            : [...this.selected, id];

        this.emitSelectionChange();
    },

    toggleVisibleRows() {
        const ids = this.visibleRows.map((row) => this.identity(row));

        this.selected = this.allVisibleSelected
            ? this.selected.filter((selected) => ! ids.includes(selected))
            : [...new Set([...this.selected, ...ids])];

        this.emitSelectionChange();
    },

    toggleSort(key) {
        const column = this.columns.find((column) => column.key === key);

        if (! column?.sortable) {
            return;
        }

        if (this.sortKey === key) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortKey = key;
            this.sortDirection = 'asc';
        }

        this.page = 1;
        this.emitQueryChange();
    },

    sortState(key) {
        if (this.sortKey !== key) {
            return 'none';
        }

        return this.sortDirection === 'asc' ? 'ascending' : 'descending';
    },

    sortIndicator(key) {
        if (this.sortKey !== key) {
            return '↕';
        }

        return this.sortDirection === 'asc' ? '↑' : '↓';
    },

    setPage(page) {
        this.page = Math.min(Math.max(1, number(page) || 1), this.totalPages);
        this.emitQueryChange();
    },

    setPerPage(perPage) {
        this.perPage = Math.max(1, number(perPage) || this.perPage);
        this.page = 1;
        this.emitQueryChange();
    },

    sync(payload = {}) {
        if (payload.id && payload.id !== this.tableId) {
            return;
        }

        if (Array.isArray(payload.data)) {
            this.data = payload.data;
        }

        if (! payload.pagination) {
            return;
        }

        const pagination = payload.pagination;

        this.controlled = pagination.mode === 'controlled' || this.controlled;
        this.page = Math.max(1, number(pagination.page) || this.page);
        this.perPage = Math.max(1, number(pagination.perPage) || this.perPage);
        this.total = Math.max(0, number(pagination.total));
        this.search = pagination.search ?? this.search;
        this.sortKey = pagination.sort?.key ?? this.sortKey;
        this.sortDirection = pagination.sort?.direction === 'desc' ? 'desc' : 'asc';
    },

    emitQueryChange() {
        this.$dispatch('query-change', {
            search: this.search,
            sort: this.sortKey ? { key: this.sortKey, direction: this.sortDirection } : null,
            page: this.page,
            perPage: this.perPage,
        });
    },

    emitSelectionChange() {
        this.$dispatch('selection-change', { selected: this.selected });
    },

    root: {
        ['@data-table:sync.window'](event) {
            this.sync(event.detail);
        },
    },
});
