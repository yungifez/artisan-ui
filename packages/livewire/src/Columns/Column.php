<?php

namespace Yungifez\AprilUI\Livewire\Columns;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Column
{
    protected bool $isSearchable = false;

    protected bool $isSortable = false;

    protected string $alignment = 'left';

    protected ?Closure $searchCallback = null;

    protected ?Closure $sortCallback = null;

    public function __construct(
        protected string $label,
        protected string $field,
    ) {
    }

    public static function make(string $label, ?string $field = null): static
    {
        return new static($label, $field ?? Str::snake($label));
    }

    public function searchable(?Closure $callback = null): static
    {
        $this->isSearchable = true;
        $this->searchCallback = $callback;

        return $this;
    }

    public function sortable(?Closure $callback = null): static
    {
        $this->isSortable = true;
        $this->sortCallback = $callback;

        return $this;
    }

    public function align(string $alignment): static
    {
        $this->alignment = in_array($alignment, ['left', 'center', 'right'], true) ? $alignment : 'left';

        return $this;
    }

    public function isSearchable(): bool
    {
        return $this->isSearchable;
    }

    public function isSortable(): bool
    {
        return $this->isSortable;
    }

    public function field(): string
    {
        return $this->field;
    }

    public function applySearch(Builder $query, string $term): void
    {
        if ($this->searchCallback) {
            ($this->searchCallback)($query, $term, $this);

            return;
        }

        $query->orWhere($this->field, 'like', "%{$term}%");
    }

    public function applySort(Builder $query, string $direction): void
    {
        if ($this->sortCallback) {
            ($this->sortCallback)($query, $direction, $this);

            return;
        }

        $query->orderBy($this->field, $direction);
    }

    public function toArray(): array
    {
        return [
            'key' => $this->field,
            'label' => $this->label,
            'searchable' => $this->isSearchable,
            'sortable' => $this->isSortable,
            'align' => $this->alignment,
        ];
    }
}
