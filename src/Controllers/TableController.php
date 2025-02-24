<?php

namespace Kathore\LaraFormik\Controllers;

use Kathore\LaraFormik\Table\Action\TableHelper;

class TableController
{
    public function __invoke()
    {
        if (TableHelper::handleActions() && TableHelper::getActionId() == "delete") {
            TableHelper::selectedItems()->delete();
            return redirect()->back()->with('success', TableHelper::requestData()->success_message);
        } else {
            $controllerClass = TableHelper::requestData()->controller;
            $action_name = 'bulkActionsHandler';
            if (class_exists($controllerClass) && method_exists($controllerClass, $action_name)) {
                $controller = app()->make($controllerClass);
                return $controller->$action_name(\request());
            } else {
                dd($action_name . ' method not define your  found. please add your controller method first.');
            }
        }
    }
}

