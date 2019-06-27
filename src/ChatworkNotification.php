<?php
declare(strict_types=1);

namespace Yokuru\Chatwork;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

abstract class ChatworkNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ChatworkChannel::class];
    }

    /**
     * Get the chatwork representation of the notification.
     *
     * @param  mixed $notifiable
     * @return ChatworkMessage
     */
    public abstract function toChatwork($notifiable): Message;
}