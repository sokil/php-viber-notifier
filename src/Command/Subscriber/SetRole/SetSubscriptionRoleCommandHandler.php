<?php

namespace Sokil\Viber\Notifier\Command\Subscriber\SetRole;

use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Command\CommandHandlerInterface;

class SetSubscriptionRoleCommandHandler implements CommandHandlerInterface
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
     * @param SetSubscriptionRoleCommand $command
     */
    public function handle($command)
    {
        if (!$command instanceof SetSubscriptionRoleCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Request must be instance of %s',
                    SetSubscriptionRoleCommand::class
                )
            );
        }

        $this->subscriberRepository->updateRole(
            $command->getSubscriberId(),
            $command->getRole()
        );
    }
}

