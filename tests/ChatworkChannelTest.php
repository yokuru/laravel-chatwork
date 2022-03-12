<?php

declare(strict_types=1);

namespace Yokuru\ChatworkTest;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;
use Mockery\MockInterface;
use Yokuru\Chatwork\ChatworkChannel;
use Yokuru\Chatwork\ChatworkException;
use Yokuru\Chatwork\ChatworkMessage;
use Yokuru\Chatwork\ChatworkNotification;

class ChatworkChannelTest extends TestCase
{
    /**
     * @var ChatworkChannel
     */
    private $target;

    /**
     * @var MockInterface
     */
    private $clientMock;

    /**
     * @var object
     */
    private $mockNotifiable;

    /**
     * @var ChatworkNotification
     */
    private $mockNotification;

    public function setUp(): void
    {
        parent::setUp();

        Config::set('chatwork.token', 'test_token');

        $this->clientMock = \Mockery::mock(Client::class)->makePartial();
        $this->target = new ChatworkChannel($this->clientMock);

        $this->mockNotifiable = new class(){
            public function routeNotificationFor($channel)
            {
                return '999999';
            }
        };

        $this->mockNotification = new class() extends ChatworkNotification{
            public function toChatwork($notifiable): ChatworkMessage
            {
                return (new ChatworkMessage)
                    ->text('test message')
                    ->selfUnread(true);
            }
        };
    }

    /**
     * it should send the request
     */
    public function testSend()
    {
        $this->clientMock
            ->shouldReceive('post')
            ->once()
            ->andReturnUsing(function ($url, $params){
                $this->assertEquals('https://api.chatwork.com/v2/rooms/999999/messages', $url);
                $this->assertEquals('test_token', $params['headers']['X-ChatWorkToken']);
                $this->assertEquals('test message', $params['form_params']['body']);
                $this->assertEquals(1, $params['form_params']['self_unread']);

                return new Response(
                    200,
                    [
                        'content-type' => 'application/json'
                    ],
                    \json_encode(['message_id' => 999999])
                );
            });

        $this->target->send($this->mockNotifiable, $this->mockNotification);
    }

    /**
     * it should throw ChatworkException if the request fails
     */
    public function testSendWithError()
    {
        $this->clientMock
            ->shouldReceive('post')
            ->once()
            ->andThrow(new \Exception());

        $this->expectException(ChatworkException::class);
        $this->target->send($this->mockNotifiable, $this->mockNotification);
    }

}