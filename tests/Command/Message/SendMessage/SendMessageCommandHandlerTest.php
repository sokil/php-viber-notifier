<?php

namespace Sokil\Viber\Notifier\Command\Message\SendMessage;

use PHPUnit\Framework\TestCase;
use Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\SubscriberListCommand;
use Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\SubscriberListCommandHandler;
use Sokil\Viber\Notifier\Entity\Subscriber;
use Sokil\Viber\Notifier\Entity\SubscriberCollection;
use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Message\TextMessage;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Service\ViberClient\ViberClientInterface;

class SendMessageCommandHandlerTest extends TestCase
{
    public function testBroadcast()
    {
        $subscriberIdCollection = new SubscriberIdCollection([
            new SubscriberId('==aaa=='),
            new SubscriberId('==bbb==')
        ]);

        $senderName = 'Sender name';
        $message = new TextMessage('Message text');

        $viberClient = $this->getMockBuilder(ViberClientInterface::class)->getMock();
        $viberClient
            ->expects($this->once())
            ->method('broadcastMessage')
            ->with(
                $senderName,
                $message,
                $this->callback(
                    function($actualSubscriberIdCollection) use ($subscriberIdCollection) {
                        /** @var SubscriberIdCollection $subscriberIdCollection */
                        $this->assertInstanceOf(SubscriberIdCollection::class, $actualSubscriberIdCollection);
                        $this->assertCount(2, $actualSubscriberIdCollection);
                        $this->assertSame($subscriberIdCollection->toScalarArray(), $actualSubscriberIdCollection->toScalarArray());

                        return true;
                    }
                )
            );

        $subscriberRepository = $this->getMockBuilder(SubscribersRepositoryInterface::class)->getMock();
        $subscriberRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn(new SubscriberCollection(
                $subscriberIdCollection->map(
                    function(SubscriberId $subscriberId) {
                        return new Subscriber(
                            $subscriberId,
                            $subscriberId->getValue() . 'Name'
                        );
                    })
                )
            );

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
            $message,
            $subscriberList->getSubscriberIdCollection()
        );

        $sendMessageCommandHandler->handle($sendMessageCommand);
    }
}