<?php

namespace Kathore\LaraFormik\Controllers;
use Kathore\LaraFormik\Table\Action\Table;

class TableController
{
    public function __invoke()
    {
        if (Table::handleActions() && Table::getActionId() == "delete") {
            Table::selectedItems()->delete();
            return redirect()->back()->with('success', Table::requestData()->success_message);
        } else {
            $controllerClass = Table::requestData()->controller;
            $action_name = Table::actionMethod();
            if (class_exists($controllerClass) && method_exists($controllerClass, $action_name)) {
                $controller = app()->make($controllerClass);
                return $controller->$action_name(\request());
            } else {
                dd($action_name . ' method not define your  found. please add your controller method first.');
            }
        }
    }
}
