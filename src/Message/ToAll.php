<?php
namespace Yokuru\Chatwork\Message;

use Yokuru\Chatwork\Message;

class ToAll implements Message
{
    public function message(): string
    {
        return '[toall]';
    }
}