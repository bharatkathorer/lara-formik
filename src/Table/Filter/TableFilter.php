<?php

namespace Kathore\LaraFormik\Table\Filter;

use Kathore\LaraFormik\Table\TableHelper;

class TableFilter
{
    protected $data = [
        'options' => [],
        'filterButton' => false,
    ];

    public function isFilterButton()
    {
        $this->data['filterButton'] = true;
        $this->init();
        return $this;  // Return the instance for chaining
    }

    public static function make(array $options = [])
    {
        $instance = new self();
        $filterData = [];
        foreach ($options as $filter) {
            if (is_object($filter) && method_exists($filter, 'init')) {
                $filterData[] = $filter->init();
            } else {
                $filterData[] = $filter;
            }
        }
        $instance->data['options'] = $filterData;
        $instance->init();
        return $instance;
    }

    protected function init()
    {
        $sharedData = array_merge($this->data, TableHelper::getControllerData());
        \Inertia\Inertia::share('modelFilter', $sharedData);
        session(['modelFilter' => $sharedData]);
    }

    public static function getIds(string $modelClass, string $columnName, string $parameterKey)
    {
        $value = request()->get($parameterKey);
        if (is_array($value)) {
            return $modelClass::whereIn($columnName, request()->get($parameterKey))->pluck('id');
        } else {
            return $modelClass::where($columnName, $value)->select('id',$columnName)->first()?->id;
        }
    }

}
