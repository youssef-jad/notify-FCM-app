<?php

namespace App\Fcm\Traits;

use App\Device;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;


trait FCMClient
{

    public $client;
    public $sound = 'default';
    public $priority = 'high';
    public $content_available = true;
    public $headers = [];
    public $fcmKey;
    public $fcm_send_url = 'https://fcm.googleapis.com/fcm/send';
    public $request;
    public $devices;

    public function __construct()
    {
        $this->fcmKey = env('FIREBASE_FCM_KEY' , 'dont hard coded here ');
        $this->headers = [
            'Authorization' => ['key=' . $this->fcmKey ],
            'Content-Type'=> 'application/json'
        ];
        $this->client = new Client();
    }


    /**
     * @param $data
     * @return array
     */
    private function setFields($data)
    {
        return [
            'registration_ids' =>  $this->getTokens($data),
            'priority' => $this->priority,
            'content_available' => $this->content_available,
            'data' => ["title" => $data->title, "body" => $data->body, 'sound' => $this->sound],
            'notification' => ["title" => $data->title, "body" => $data->body, 'sound' => $this->sound],
        ];
    }

    /**
     * @param $jsonData
     * @return FCMClient
     */
    private function request($jsonData)
    {
        return $this->request = $this->client->post(
            $this->fcm_send_url,
            [
                'headers' => $this->headers,
                'json' => $jsonData
            ]
        );
    }


    /**
     * @param \Psr\Http\Message\ResponseInterface $request
     * @return array
     */
    private function response(\Psr\Http\Message\ResponseInterface $request)
    {
        $decodedResult = json_decode($this->request->getBody()->getContents());
        return [
            'multicast_id' => $decodedResult->multicast_id,
            'success' => $decodedResult->success,
            'failure' => $decodedResult->failure,
            'canonical_ids' => $decodedResult->canonical_ids,
            'response_code' => $request->getStatusCode(),
            'results' => $decodedResult->results,
        ];;
    }

    /**
     * @param $data
     * @param $fields
     * @return mixed
     */
    protected function setFieldsData($data, $fields)
    {
        if (count($data) > 0) {
            $fields[ 'data' ] = $data;
        }
        return $fields;
    }

    /**
     * @param $data
     * @return array
     */
    private function getTokens($data)
    {

        // 
        if ($data->user == null) {
            // set Tokens to Bulk
            $this->devices = new Device();
            return $this->devices->groupedKeys()->pluck('device_key')->toArray();
        }

        return $data->user->devices->pluck('device_key')->toArray();
    }


}
