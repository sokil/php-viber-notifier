<?php

namespace Sokil\Viber\Notifier\Command\Subscriber\SubscriberList;

use Sokil\Viber\Notifier\Entity\Subscriber;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Command\CommandHandlerInterface;

class SubscriberListCommandHandler implements CommandHandlerInterface
{
    /**
     * @var SubscribersRepositoryInterface
     */
    private $subscriberRepository;

    /**
     * @param SubscriberListCommand $command
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

        return $subscribers->map(
            function(Subscriber $subscriber) {
                return [
                    'id' => $subscriber->getId()->getValue(),
                    'name' => $subscriber->getName(),
                ];
            }
        );
    }

}