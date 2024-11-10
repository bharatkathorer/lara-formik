<?php

namespace Kathore\LaraFormik\Table\Action;

use Kathore\LaraFormik\Table\TableHelper;

class TableActionMenu
{
    protected $data = [
        'options' => [],
        'isPaginateSelect' => false,
        'actionMethod' => 'tableActions',
    ];

    public function isPaginated()
    {
        $this->data['isPaginateSelect'] = true;
        $this->init();
        return $this;  // Return the instance for chaining
    }

    public function actionMethod(string $method)
    {
        $this->data['actionMethod'] = $method;
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
        $sharedData = [
            ...$this->data,
            ...TableHelper::getControllerData()
        ];
        \Inertia\Inertia::share('actions', $sharedData);
        session(['actions' => $sharedData]);
    }
}
