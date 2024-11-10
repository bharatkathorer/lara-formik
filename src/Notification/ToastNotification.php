<?php

namespace Kathore\LaraFormik\Notification;
use Illuminate\Support\Facades\Session;

class ToastNotification
{
    public static function init()
    {
        return [
            'success' => session('success'),
            'error' => session('error'),
            'warning' => session('warning'),
        ];
    }

    public static function success($message): void
    {
        Session::flash('success', $message);
    }

    public static function error($message): void
    {
        Session::flash('error', $message);
    }

    public static function warning($message): void
    {
        Session::flash('warning', $message);
    }
}
