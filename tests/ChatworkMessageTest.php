<?php
declare(strict_types=1);

namespace Yokuru\ChatworkTest;

use Yokuru\Chatwork\ChatworkMessage;

class ChatworkMessageTest extends TestCase
{
    /**
     * @var ChatworkMessage
     */
    private $target;

    protected function setUp(): void
    {
        parent::setUp();
        $this->target = new ChatworkMessage();
    }

    /**
     * it should build a chat message
     */
    public function testBuildMessages()
    {
        $this->target
            ->to('99999999')
            ->text('simple text')
            ->toAll()
            ->info('information text', 'information title');

        $this->assertEquals(
            "[To:99999999]\n"
            . "simple text\n"
            . "[toall]\n"
            . "[info][title]information title[/title]information text[/info]",
            $this->target->message()
        );
    }

    /**
     * it should set a self unread flag
     */
    public function testSelfUnread()
    {
        $this->target->selfUnread(false);
        $this->assertEquals(0, $this->target->selfUnreadStatus);

        $this->target->selfUnread(true);
        $this->assertEquals(1, $this->target->selfUnreadStatus);
    }
}