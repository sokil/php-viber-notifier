<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\Subscriber\SubscriberList;

use Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\Result\Subscriber;
use Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\Result\SubscriberList;
use Sokil\Viber\Notifier\Entity\Subscriber as SubscriberEntity;
use Sokil\Viber\Notifier\Repository\SubscriberRepositoryFilter;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Command\CommandHandlerInterface;

class SubscriberListCommandHandler implements CommandHandlerInterface
{
    /**
     * @var SubscribersRepositoryInterface
     */
    private $subscriberRepository;

    /**
     */
    public function __construct(SubscribersRepositoryInterface $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     *
     * @return SubscriberList
     */
    public function handle(SubscriberListCommand $command)
    {
        if (!$command instanceof SubscriberListCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Request must be instance of %s',
                    SubscriberListCommand::class
                )
            );
        }

        $subscribersFilter = new SubscriberRepositoryFilter();

        $subscribersFilter->setActive();

        if ($command->getRoles() !== null) {
            $subscribersFilter->setRoles($command->getRoles());
        }

        $subscribers = $this->subscriberRepository->findAll(
            $subscribersFilter,
            $command->getLimit(),
            $command->getOffset()
        );

        return new SubscriberList(
            $subscribers->map(
                function (SubscriberEntity $subscriber) {
                    return new Subscriber(
                        $subscriber->getId(),
                        $subscriber->getName()
                    );
                }
            )
        );
    }
}
