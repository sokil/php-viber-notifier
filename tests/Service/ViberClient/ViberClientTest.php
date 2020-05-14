<?php

namespace Sokil\Viber\Notifier\Service\ViberClient;

use PHPUnit\Framework\TestCase;
use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Message\TextMessage;
use Sokil\Viber\Notifier\Tools\Http\Client\HttpClientInterface;

class ViberClientTest extends TestCase
{
    public function testSetWebHookUrk()
    {
        $authToken = 'AuthToken';
        $webHookUrl = 'https://sevrer.com/webhook';

        $httpClient = $this->getMockBuilder(HttpClientInterface::class)->getMock();
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                'https://chatapi.viber.com/pa/set_webhook',
                $this->callback(function(array $headers) use($authToken) {
                    $this->assertArrayHasKey('X-Viber-Auth-Token', $headers);
                    $this->assertSame($authToken, $headers['X-Viber-Auth-Token']);

                    return true;
                }),
                $this->callback(function(array $body) use($webHookUrl) {
                    $this->assertArrayHasKey('url', $body);
                    $this->assertSame($webHookUrl, $body['url']);

                    return true;
                })
            )
            ->willReturn(
                [
                    "status" => 0,
                    "status_message" => "ok",
                    "chat_hostname" => "SN-CHAT-03_",
                    "event_types" => [
                        "subscribed",
                        "unsubscribed",
                        "webhook",
                        "conversation_started",
                        "action",
                        "delivered",
                        "failed",
                        "message",
                        "seen"
                    ]
                ]
            );

        $viberClient = new ViberClient(
            $httpClient,
            $authToken
        );

        $viberClient->setWebHookUrl($webHookUrl);
    }

    public function testBroadcastMessage()
    {
        $authToken = 'AuthToken';
        $subscriberIdCollection = new SubscriberIdCollection([
            new SubscriberId('===aaa==='),
            new SubscriberId('===bbb==='),
        ]);

        $httpClient = $this->getMockBuilder(HttpClientInterface::class)->getMock();
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                'https://chatapi.viber.com/pa/broadcast_message',
                $this->callback(function(array $headers) use($authToken) {
                    $this->assertArrayHasKey('X-Viber-Auth-Token', $headers);
                    $this->assertSame($authToken, $headers['X-Viber-Auth-Token']);

                    return true;
                }),
                $this->callback(function(array $body) use($subscriberIdCollection) {
                    $this->assertArrayHasKey('broadcast_list', $body);
                    $this->assertSame($subscriberIdCollection->toScalarArray(), $body['broadcast_list']);

                    return true;
                })
            )
            ->willReturn(
                [
                    "status" => 0,
                    "status_message" => "ok",
                    "failed_list" => [
                        [
                            "receiver" => "===bbb===",
                            "status" => 6,
                            "status_message" => "Not subscribed"
                        ]
                    ]
                ]
            );

        $viberClient = new ViberClient(
            $httpClient,
            $authToken
        );

        $statusCollection = $viberClient->broadcastMessage(
            'sender name',
            new TextMessage('message text'),
            $subscriberIdCollection
        );

        $this->assertCount(1, $statusCollection);
        $status = $statusCollection->current();

        $this->assertSame('===bbb===', $status->getSubscriberId()->getValue());
        $this->assertSame(6, $status->getStatus());
        $this->assertSame('Not subscribed', $status->getStatusMessage());
    }

    public function testSendMessage()
    {
        $authToken = 'AuthToken';
        $subscriberId = new SubscriberId('===aaa===');

        $httpClient = $this->getMockBuilder(HttpClientInterface::class)->getMock();
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                'https://chatapi.viber.com/pa/send_message',
                $this->callback(function(array $headers) use($authToken) {
                    $this->assertArrayHasKey('X-Viber-Auth-Token', $headers);
                    $this->assertSame($authToken, $headers['X-Viber-Auth-Token']);

                    return true;
                }),
                $this->callback(function(array $body) use($subscriberId) {
                    $this->assertArrayHasKey('receiver', $body);
                    $this->assertSame($subscriberId->getValue(), $body['receiver']);

                    return true;
                })
            )
            ->willReturn(
                [
                    "status" => 0,
                    "status_message" => "ok",
                ]
            );

        $viberClient = new ViberClient(
            $httpClient,
            $authToken
        );

        $status = $viberClient->sendMessage(
            'sender name',
            new TextMessage('message text'),
            $subscriberId
        );

        $this->assertSame('===aaa===', $status->getSubscriberId()->getValue());
        $this->assertSame(0, $status->getStatus());
        $this->assertSame('ok', $status->getStatusMessage());
    }
}