# April UI Livewire

Optional Livewire adapter for April UI data tables.

```php
use Illuminate\Database\Eloquent\Builder;
use Yungifez\AprilUI\Livewire\Columns\Column;
use Yungifez\AprilUI\Livewire\DataTableComponent;

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

Render it with `<livewire:users-table />`. The adapter owns Eloquent query state and pagination. It renders the framework-neutral April data table in controlled mode.
