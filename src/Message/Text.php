<?php
namespace Yokuru\Chatwork\Message;

use Yokuru\Chatwork\Message;

class Text implements Message
{
    /**
     * @var string
     */
    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function message(): string
    {
        return $this->message;
    }
}
