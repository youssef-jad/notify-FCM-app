<?php

namespace App\FCM;

use App\Fcm\Handlers\SendBulkPushNotifications;
use App\Fcm\Handlers\SendPushNotificationsToUser;
use App\Fcm\Interfaces\FCMCFactoryContract;
use App\Fcm\Traits\FCMClient;
use App\User;

class FCMFactory implements FCMCFactoryContract
{
    public $title = 'Default Title';
    public $body = 'Default Body Content';
    public $user;
    public $data = [];

    /**
     * FCMClient constructor.
     *
     * @param User|null $user
     */
    public function __construct(User $user = null)
    {
        if (func_num_args() == 1 && $user == null) {
            throw new \Exception('Careful The User You are trying to send notification to him not exists');
        }
        $this->user = $user;
    }

    public function notify()
    {
        if ($this->user != null) {
            return $this->SendToUser();
        }
        if ($this->user == null) {
            return $this->BulkSend();
        }
    }

    protected function sendToUser()
    {
        return (new SendPushNotificationsToUser())->send($this);
    }

    protected function BulkSend()
    {
        return (new SendBulkPushNotifications())->send($this);
    }
}
