<?php
namespace Yokuru\Chatwork\Message;

use Yokuru\Chatwork\Message;

class Info implements Message
{
    /**
     * Information body
     * @var string
     */
    private $body;

    /**
     * Information title
     * @var string|null
     */
    private $title;

    public function __construct(string $body, string $title = null)
    {
        $this->body = $body;
        $this->title = $title;
    }

    public function message(): string
    {
        $title = $this->title ? '[title]' . $this->title . '[/title]' : '';
        return '[info]' . $title . $this->body . '[/info]';
    }
}