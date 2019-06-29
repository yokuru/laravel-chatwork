<?php
declare(strict_types=1);

namespace Yokuru\Chatwork;

use Yokuru\Chatwork\Message\Info;
use Yokuru\Chatwork\Message\Text;
use Yokuru\Chatwork\Message\To;
use Yokuru\Chatwork\Message\ToAll;

class ChatworkMessage implements Message
{
    /**
     * @var Message[]
     */
    public $messages = [];

    /**
     * @var int
     */
    public $selfUnreadStatus;

    /**
     * Set a self unread flag
     * @param bool $unread
     * @return ChatworkMessage
     */
    public function selfUnread(bool $unread): self
    {
        $this->selfUnreadStatus = (int) $unread;
        return $this;
    }

    /**
     * Add a plain text
     * @param string $message
     * @return ChatworkMessage
     */
    public function text(string $message): self
    {
        $this->messages[] = new Text($message);
        return $this;
    }

    /**
     * Add an information block
     * @param string $message
     * @param string|null $title
     * @return ChatworkMessage
     */
    public function info(string $message, string $title = null): self
    {
        $this->messages[] = new Info($message, $title);
        return $this;
    }

    /**
     * Add mention to the target user
     * @param string $id Account id of the target user
     * @return ChatworkMessage
     */
    public function to(string $id): self
    {
        $this->messages[] = new To($id);
        return $this;
    }

    /**
     * Add mention to all users on the room
     * @return ChatworkMessage
     */
    public function toAll(): self
    {
        $this->messages[] = new ToAll();
        return $this;
    }

    /**
     * Build message
     * @return string
     */
    public function message(): string
    {
        return implode("\n", array_map(function (Message $m) {
            return $m->message();
        }, $this->messages));
    }
}
