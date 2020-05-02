<?php

namespace Sokil\Viber\Notifier\Command\Subscriber\SubscriberList;

use Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\Result\Subscriber;
use Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\Result\SubscriberList;
use Sokil\Viber\Notifier\Entity\Subscriber as SubscriberEntity;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Command\CommandHandlerInterface;

class SubscriberListCommandHandler implements CommandHandlerInterface
{
    /**
     * @var SubscribersRepositoryInterface
     */
    private $subscriberRepository;

    /**
     * @param SubscribersRepositoryInterface $subscriberRepository
     */
    public function __construct(SubscribersRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * @param SubscriberListCommand $command
     *
     * @return SubscriberList
     */
    public function handle($command)
    {
        if (!$command instanceof SubscriberListCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Request must be instance of %s',
                    SubscriberListCommand::class
                )
            );
        }

        $subscribers = $this->subscriberRepository->findAllByRole($command->getRole());

        return new SubscriberList(
            $subscribers->map(
                function(SubscriberEntity $subscriber) {
                    return new Subscriber(
                        $subscriber->getId(),
                        $subscriber->getName()
                    );
                }
            )
        );
    }

}