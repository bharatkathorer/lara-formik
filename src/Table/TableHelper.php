<?php

namespace Kathore\LaraFormik\Table;

use Illuminate\Support\Facades\Route;

class TableHelper
{
    public static function getControllerData()
    {
        $routeAction = Route::currentRouteAction();
        [$controller, $action] = explode('@', $routeAction);
        return [
            'controller' => $controller,
            'action' => $action,
        ];
    }

    public function getOldData($dataKey = 'modelFilter')
    {
        if (request()->ajax()) {
            try {
                $modelFilter = session('modelFilter');
                return $modelFilter;
            } catch (\Exception $e) {
                return null;
            }
        }
    }
}
