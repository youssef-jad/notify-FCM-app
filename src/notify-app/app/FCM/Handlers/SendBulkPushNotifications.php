<?php

namespace App\Fcm\Handlers;

use App\Fcm\Interfaces\SendNotificationsContract;
use App\Fcm\Traits\FCMClient;

class SendBulkPushNotifications implements SendNotificationsContract
{
    use FCMClient;

    public function send($data)
    {
        try {
            $jsonData = $this->setFieldsData($data->data, $this->setFields($data));
            $this->request($jsonData);

            return $this->response($this->request);
        } catch (Exception $e) {
            return $e;
        }
    }
}
