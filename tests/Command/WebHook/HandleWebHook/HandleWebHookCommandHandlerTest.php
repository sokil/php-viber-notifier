<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\WebHook\HandleWebHook;

use PHPUnit\Framework\TestCase;
use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;

class HandleWebHookCommandHandlerTest extends TestCase
{
    public function subscribeDataProvider()
    {
        $viberUserId = base64_encode(hex2bin('d5241619e59440b447c2721c360fb648'));
        $viberUserName = 'User name';

        return [
            'subscribed' => [
                'viberUserId' => $viberUserId,
                'viberUserName' => $viberUserName,
                'event' => [
                    "event" => "conversation_started",
                    "timestamp" => 1550094695703,
                    "chat_hostname" => "SN-350_",
                    "message_token" => 523345426228,
                    "type" => "open",
                    "user" => [
                        "id" => $viberUserId,
                        "name" => $viberUserName,
                        "avatar" => "https => //example.com/image",
                        "language" => "en",
                        "country" => "UA",
                        "api_version" => 7,
                        "subscribed" => false,
                    ],
                ]
            ],
            'conversation_started' => [
                'viberUserId' => $viberUserId,
                'viberUserName' => $viberUserName,
                'event' => [
                    "event" => "conversation_started",
                    "timestamp" => 1550094695703,
                    "chat_hostname" => "SN-350_",
                    "message_token" => 523345426228,
                    "type" => "open",
                    "user" => [
                        "id" => $viberUserId,
                        "name" => $viberUserName,
                        "avatar" => "https => //example.com/image",
                        "language" => "en",
                        "country" => "UA",
                        "api_version" => 7,
                        "subscribed" => false,
                    ],
                ],
            ]
        ];
    }

    /**
     * @dataProvider subscribeDataProvider
     *
     * @param array $event
     */
    public function testSubscribe(string $viberUserId, string $viberUserName, array $event)
    {
        $command = new HandleWebHookCommand(
            $event
        );

        $subscribersRepository = $this->getMockBuilder(SubscribersRepositoryInterface::class)->getMock();
        $subscribersRepository
            ->expects($this->once())
            ->method('subscribe')
            ->with(
                $this->callback(function ($subscriberId) use ($viberUserId) {
                    /** @var SubscriberId $subscriberId */
                    $this->assertInstanceOf(SubscriberId::class, $subscriberId);
                    $this->assertSame($viberUserId, $subscriberId->getValue());

                    return true;
                }),
                $viberUserName
            );

        $commandHandler = new HandleWebHookCommandHandler(
            $subscribersRepository
        );

        $commandHandler->handle($command);
    }

    public function testUnsubscribe()
    {
        $viberUserId = base64_encode(hex2bin('d5241619e59440b447c2721c360fb648'));

        $command = new HandleWebHookCommand(
            [
                "event" => "unsubscribed",
                "user_id" => $viberUserId,
            ]
        );

        $subscribersRepository = $this->getMockBuilder(SubscribersRepositoryInterface::class)->getMock();
        $subscribersRepository
            ->expects($this->once())
            ->method('unsubscribe')
            ->with(
                $this->callback(function ($subscriberId) use ($viberUserId) {
                    /** @var SubscriberId $subscriberId */
                    $this->assertInstanceOf(SubscriberId::class, $subscriberId);
                    $this->assertSame($viberUserId, $subscriberId->getValue());

                    return true;
                })
            );

        $commandHandler = new HandleWebHookCommandHandler(
            $subscribersRepository
        );

        $commandHandler->handle($command);
    }
}
