<?php
declare(strict_types=1);

namespace Yokuru\Chatwork;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class ChatworkChannel
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, ChatworkNotification $notification)
    {
        $chatworkMessage = $notification->toChatwork($notifiable);
        $roomId = $notifiable->routeNotificationFor('chatwork');

        try {
            $this->client->post('https://api.chatwork.com/v2/rooms/' . $roomId . '/messages', [
                'headers' => [
                    'X-ChatWorkToken' => Config::get('chatwork.token'),
                ],
                'form_params' => [
                    'body' => $chatworkMessage->message(),
                    'self_unread' => (int) $chatworkMessage->isSelfUnread,
                ],
            ]);
        } catch (\Exception $e) {
            throw new ChatworkException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }

}