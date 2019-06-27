<?php
namespace Yokuru\Chatwork\Message;

use Yokuru\Chatwork\Message;

class To implements Message
{
    /**
     * @var string
     */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function message(): string
    {
        return '[To:' . $this->id . ']';
    }
}
