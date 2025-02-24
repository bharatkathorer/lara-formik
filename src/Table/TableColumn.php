<?php

namespace App\VueTable\Table;
class TableColumn
{

    protected bool $isSearchable = false;
    protected bool $isSortable = false;
    protected string $label = '';
    public string $key = '';
    protected ?\Closure $searchQuery = null;

    public static function make($key): self
    {
        $instance = new self();
        $instance->key = $key;
        $instance->label = str_replace('_', ' ', $key);
        return $instance;
    }

    public function label($value): self
    {
        $this->label = $value;
        return $this;
    }

    public function searchable(?\Closure $searchQuery = null): self
    {
        $this->isSearchable = true;
        if ($searchQuery) {
            $this->searchQuery = $searchQuery;
        }
        return $this;
    }

    public function isSearchable(): bool
    {
        return $this->isSearchable;
    }

    public function sortable(): self
    {
        $this->isSortable = true;
        return $this;
    }


    public function isSortable(): bool
    {
        return $this->isSortable;
    }

    public function applySearch($query, $searchValue)
    {
        if ($this->searchQuery) {
            call_user_func($this->searchQuery, $query, $searchValue);
        } else {
            $query->orWhere($this->key, 'like', "%{$searchValue}%");
        }

        return $query;
    }

    public function init(): array
    {
        return
            [
                'label' => $this->label,
                'key' => $this->key,
                'isSearchable' => $this->isSearchable,
                'sortKey' => $this->isSortable ? $this->key : null,
            ];
    }
}
