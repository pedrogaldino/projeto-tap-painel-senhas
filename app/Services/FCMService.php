<?php

namespace App\Services;

use Httpful\Mime;
use Httpful\Request;

class FCMService
{

    public static function sendNotification($token, $title, $body, $clickLink = null, $icon = null)
    {
        $data = [
            'notification' => [
                'title' => $title,
                'body' => $body,
                'click_action' => $clickLink,
                'icon' => $icon
            ],
            'to' => $token,
            'priority' => 'high'
        ];

        // Aqui você pode colocar como uma váriavel de ambiente mais tarde, jovem gafanhoto.
        $url = 'https://fcm.googleapis.com/fcm/send';

        $res = Request::post($url)
            ->sends(Mime::JSON)
            ->body(json_encode($data))
            ->addHeader('Authorization', 'key=' . config('services.firebase.server_key'))
            ->send();

        return $res;
    }

}
