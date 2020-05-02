<?php

namespace Sokil\Viber\Notifier\Command\WebHook\HandleWebHook;

use PHPUnit\Framework\TestCase;
use Sokil\Viber\Notifier\Entity\Role;
use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;

class HandleWebHookCommandHandlerTest extends TestCase
{
    public function subscribeDataProvider()
    {
        $viberUserId = 'xxxffff==';
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
     * @param string $viberUserId
     * @param string $viberUserName
     * @param array $event
     */
    public function testSubscribe($viberUserId, $viberUserName, array $event)
    {
        $command = new HandleWebHookCommand(
            $event
        );

        $defaultRole = new Role('guest');

        $subscribersRepository = $this->createMock(SubscribersRepositoryInterface::class);
        $subscribersRepository
            ->expects($this->once())
            ->method('subscribe')
            ->with(
                $this->callback(function($subscriberId) use ($viberUserId) {
                    /** @var SubscriberId $subscriberId */
                    $this->assertInstanceOf(SubscriberId::class, $subscriberId);
                    $this->assertSame($viberUserId, $subscriberId->getValue());

                    return true;
                }),
                $viberUserName,
                $defaultRole
            );

        $commandHandler = new HandleWebHookCommandHandler(
            $defaultRole,
            $subscribersRepository
        );

        $commandHandler->handle($command);
    }

    public function testUnsubscribe()
    {
        $viberUserId = 'xxxffff==';

        $command = new HandleWebHookCommand(
            [
                "event" => "unsubscribed",
                "user_id" => $viberUserId,
            ]
        );

        $subscribersRepository = $this->createMock(SubscribersRepositoryInterface::class);
        $subscribersRepository
            ->expects($this->once())
            ->method('unsubscribe')
            ->with(
                $this->callback(function($subscriberId) use ($viberUserId) {
                    /** @var SubscriberId $subscriberId */
                    $this->assertInstanceOf(SubscriberId::class, $subscriberId);
                    $this->assertSame($viberUserId, $subscriberId->getValue());

                    return true;
                })
            );

        $commandHandler = new HandleWebHookCommandHandler(
            new Role('guest'),
            $subscribersRepository
        );

        $commandHandler->handle($command);
    }
}