<?php

namespace Sokil\Viber\Notifier\Command\Message\SendMessage;

use PHPUnit\Framework\TestCase;
use Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\SubscriberListCommand;
use Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\SubscriberListCommandHandler;
use Sokil\Viber\Notifier\Entity\Subscriber;
use Sokil\Viber\Notifier\Entity\SubscriberCollection;
use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Service\ViberClient\ViberClientInterface;

class SendMessageCommandHandlerTest extends TestCase
{
    public function testBroadcast()
    {
        $subscriberId = new SubscriberId('==xxffgg==');
        $subscriberName = 'Subscriber name';
        $senderName = 'Sender name';
        $message = 'Message text';

        $viberClient = $this->getMockBuilder(ViberClientInterface::class)->getMock();
        $viberClient
            ->expects($this->once())
            ->method('broadcastMessage')
            ->with(
                $senderName,
                $message,
                $this->callback(
                    function($subscriberIdCollection) use ($subscriberId) {
                        /** @var SubscriberIdCollection $subscriberIdCollection */
                        $this->assertInstanceOf(SubscriberIdCollection::class, $subscriberIdCollection);
                        $this->assertCount(1, $subscriberIdCollection);
                        $this->assertSame($subscriberId->getValue(), $subscriberIdCollection->current()->getValue());

                        return true;
                    }
                )
            );

        $subscriberRepository = $this->getMockBuilder(SubscribersRepositoryInterface::class)->getMock();
        $subscriberRepository
            ->expects($this->once())
            ->method('findAllByRole')
            ->willReturn(new SubscriberCollection(
                [
                    new Subscriber(
                        $subscriberId,
                        $subscriberName
                    )
                ]
            ));

        $subscriberListCommandHandler = new SubscriberListCommandHandler(
            $subscriberRepository
        );

        $sendMessageCommandHandler = new SendMessageCommandHandler(
            $viberClient
        );

        $subscriberListCommand = new SubscriberListCommand(
            null,
            100,
            0
        );

        $subscriberList = $subscriberListCommandHandler->handle($subscriberListCommand);

        $sendMessageCommand = new SendMessageCommand(
            'Sender name',
            'Message text',
            $subscriberList->getSubscriberIdCollection()
        );

        $sendMessageCommandHandler->handle($sendMessageCommand);
    }
}