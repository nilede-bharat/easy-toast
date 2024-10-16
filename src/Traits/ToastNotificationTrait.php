<?php


namespace EasyToast\Traits;


use Illuminate\Support\Facades\Session;

trait ToastNotificationTrait
{
    public function init()
    {
        return [
            'success' => session('success'),
            'error' => session('error'),
            'warning' => session('warning'),
        ];
    }
    public function success($message): void
    {
        Session::flash('success', $message);
    }

    public function error($message): void
    {
        Session::flash('error', $message);
    }

    public function warning($message): void
    {
        Session::flash('warning', $message);
    }
}
