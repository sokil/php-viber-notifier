<?php

declare(strict_types=1);

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
                $this->callback(function (array $headers) use ($authToken) {
                    $this->assertArrayHasKey('X-Viber-Auth-Token', $headers);
                    $this->assertSame($authToken, $headers['X-Viber-Auth-Token']);

                    return true;
                }),
                $this->callback(function (array $body) use ($webHookUrl) {
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
            new SubscriberId(base64_encode(hex2bin('355be750e9aee9125def9effef5d9426'))),
            new SubscriberId(base64_encode(hex2bin('d33d1e9f91b4f41f57ab2110be4ac487'))),
        ]);

        $httpClient = $this->getMockBuilder(HttpClientInterface::class)->getMock();
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                'https://chatapi.viber.com/pa/broadcast_message',
                $this->callback(function (array $headers) use ($authToken) {
                    $this->assertArrayHasKey('X-Viber-Auth-Token', $headers);
                    $this->assertSame($authToken, $headers['X-Viber-Auth-Token']);

                    return true;
                }),
                $this->callback(function (array $body) use ($subscriberIdCollection) {
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
                            "receiver" => base64_encode(hex2bin('d33d1e9f91b4f41f57ab2110be4ac487')),
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

        $this->assertSame(
            base64_encode(hex2bin('d33d1e9f91b4f41f57ab2110be4ac487')),
            $status->getSubscriberId()->getValue()
        );
        $this->assertSame(6, $status->getStatus());
        $this->assertSame('Not subscribed', $status->getStatusMessage());
    }

    public function testSendMessage()
    {
        $authToken = 'AuthToken';
        $subscriberId = new SubscriberId(base64_encode(hex2bin('c7272dd64f77c5be33a3975094427b98')));

        $httpClient = $this->getMockBuilder(HttpClientInterface::class)->getMock();
        $httpClient
            ->expects($this->once())
            ->method('request')
            ->with(
                'https://chatapi.viber.com/pa/send_message',
                $this->callback(function (array $headers) use ($authToken) {
                    $this->assertArrayHasKey('X-Viber-Auth-Token', $headers);
                    $this->assertSame($authToken, $headers['X-Viber-Auth-Token']);

                    return true;
                }),
                $this->callback(function (array $body) use ($subscriberId) {
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

        $this->assertSame($subscriberId->getValue(), $status->getSubscriberId()->getValue());
        $this->assertSame(0, $status->getStatus());
        $this->assertSame('ok', $status->getStatusMessage());
    }
}
