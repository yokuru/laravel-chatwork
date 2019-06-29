<?php
declare(strict_types=1);

namespace Yokuru\ChatworkTest\Message;

use Yokuru\Chatwork\Message\Info;
use Yokuru\ChatworkTest\TestCase;

class InfoTest extends TestCase
{

    public function testWithoutTitle() {
        $info = new Info('message');
        $this->assertEquals('[info]message[/info]', $info->message());
    }

    public function testWithTitle() {
        $info = new Info('message', 'title');
        $this->assertEquals('[info][title]title[/title]message[/info]', $info->message());
    }

}