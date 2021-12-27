<?php

namespace App\Http\Controllers;

use App\FCM\FCMFactory;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function home()
    {
        return view('welcome');
    }

    public function toSingleUser()
    {
        $user = User::first();
        $notifyUser = new FCMFactory($user);
        $notifyUser->title = 'Duck You ';
        $notifyUser->data = [
            'key' => 'value',
        ];
        $result = $notifyUser->notify();

        return view('welcome', ['data' => $result]);
    }

    public function BulkSend()
    {
        $bulkNotify = new FCMFactory();
        $bulkNotify->title = 'Surprise Beach !';
        $bulkNotify->data = [
            'key' => 'value',
        ];
        $result = $bulkNotify->notify();

        return view('welcome', ['data' => $result]);
    }
}
