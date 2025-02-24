<?php

namespace Kathore\LaraFormik;

use Illuminate\Database\Eloquent\Builder;
use Kathore\LaraFormik\Table\TableHelper;

class Table
{
    protected Builder $query;
    protected string $model;
    protected mixed $globalQuery;
    protected array $columns = [];
    protected array $filters = [];
    protected array $data = [
        'label' => null,
        'options' => [],
        'filterButton' => true,
        'isPaginateSelect' => true,
        'createAction'=>null
    ];
    protected array $bulkActionsMethods = [];
    protected array $bulkActions = [];

    public static function make(string $model): self
    {
        $instance = new self();
        $instance->model = $model;
        $instance->query = $model::query();
        return $instance;
    }


    public function bulkActions(array $actions): self
    {
        $this->bulkActionsMethods = $actions;
        return $this;
    }

    public function label(string $label): self
    {
        $this->data['label'] = $label;
        return $this;
    }

    public function createActionButton(string $label, string $href): self
    {
        $this->data['createAction'] = [
            'label' => $label,
            'href' => $href,
        ];
        return $this;
    }

    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function isPreventState(bool $value): self
    {
        $this->data['isPaginateSelect'] = $value;
        return $this;
    }

    public function filters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    private function applyFilters(): self
    {
        $request = request();
        foreach ($this->filters as $filter) {
            $key = $filter->getKey();
            if ($request->has($key)) {
                $value = $request->input($key);
                $this->query = $filter->apply($this->query, $value);
            }
        }
        return $this;
    }

    public function query(callable $callback): self
    {
        $this->globalQuery = $callback;
        return $this;
    }

    private function applyGlobalQuery(): void
    {
        if ($this->globalQuery) {
            call_user_func($this->globalQuery, $this->query);
        }
    }


    public function paginate($perPage = 10): array
    {
        return $this->collectData($perPage);
    }

    public function get(): array
    {
        return $this->collectData();
    }

    protected function applySearch(): void
    {
        $keywords = request()->get('keyword');
        if (!$keywords) {
            return;
        }

        $this->query->where(function ($query) use ($keywords) {
            foreach ($this->columns as $column) {
                if ($column->isSearchable()) {
                    $column->applySearch($query, $keywords);
                }
            }
        });
    }

    protected function applySort(): void
    {
        foreach ($this->columns as $column) {
            if ($column->isSortable()) {
                $sort = request()->get("order_by_{$column->key}");
                if ($sort) {
                    $this->query->orderBy($column->key, $sort);
                }
            }
        }
    }


    protected function applyBulkActions(): void
    {
        foreach ($this->bulkActionsMethods as $filter) {
            if (is_object($filter) && method_exists($filter, 'init')) {
                $data = $filter->init($this->model);
                if (!$data['modal']) {
                    $data['modal'] = $this->model;
                }
                $this->bulkActions[] = $data;
            } else {
                $this->bulkActions[] = $filter;
            }
        }
    }

    protected function collectData($perPage = null): array
    {
        $this->applySearch();
        $this->applyFilters();
        $this->applyGlobalQuery();
        $this->applySort();
        $this->applyBulkActions();

        $this->data['options'] = array_map(function ($filter) {
            if (is_object($filter) && method_exists($filter, 'init')) {
                return $filter->init();
            } else {
                return $filter;
            }
        }, $this->filters);

        $columns = array_map(function ($column) {
            if (is_object($column) && method_exists($column, 'init')) {
                return $column->init();
            } else {
                return $column;
            }
        }, $this->columns);

        $sharedData = [
            'data' => $perPage ? $this->query->paginate($perPage) : $this->query->get(),
            'columns' => $columns,
            'actionMethod' => $this->bulkActions,
            ...$this->data,
            ...TableHelper::getControllerData(),
        ];

//        dd($sharedData);
        \Inertia\Inertia::share('modelFilter', $sharedData);
        return $sharedData;
    }
}
