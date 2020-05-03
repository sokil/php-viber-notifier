<?php

namespace Sokil\Viber\Notifier\Service\ViberClient;

use PHPUnit\Framework\TestCase;
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
        $this->markTestSkipped();
    }
}