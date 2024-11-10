<?php

namespace Kathore\LaraFormik\Table\Action;

class Table
{
    public static function getActionId(): string
    {
        return self::requestData()->id;
    }

    public static function handleActions(): string
    {
        return self::requestData()->handleActions;
    }

    public static function actionMethod(): string
    {

        return self::requestData()->actionMethod;
    }

    public static function requestData()
    {
        return json_decode(json_encode(request()->all()))->_data;
    }

    public static function selectedItems(callable $queryCallback = null)
    {
        $_data = self::requestData();
        // Get model and selected IDs from the request
        $model = $_data->modal;
        $selectedIds = $_data->selectedData;

        // Start the query
        $query = $model::whereIn('id', $selectedIds);

        // Apply additional conditions if the callback is provided
        if ($queryCallback) {
            $queryCallback($query);
        }

        // Return the query builder instance so you can chain further methods
        return $query;
    }

}
