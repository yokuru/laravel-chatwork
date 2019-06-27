<?php
declare(strict_types=1);

namespace Yokuru\Chatwork;

use GuzzleHttp\Client;

class ChatworkChannel
{
    public function send($notificable, ChatworkNotification $notification)
    {
        $message = $notification->toChatwork($notificable)->message();
        $roomId = $notificable->routeNotificationFor('chatwork');

        $req = new Client();
        $response = $req->post('https://api.chatwork.com/v2/rooms/' . $roomId . '/messages', [
            'headers' => [
                'X-ChatWorkToken' => config('chatwork.token'),
            ],
            'form_params' => [
                'body' => $message,
                'self_unread' => 0,
            ],
        ]);

        // TODO handling error
    }

}