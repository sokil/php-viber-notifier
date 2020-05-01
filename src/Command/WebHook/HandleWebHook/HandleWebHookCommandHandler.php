<?php

namespace Sokil\Viber\Notifier\Command\WebHook\HandleWebHook;

use Sokil\Viber\Notifier\Entity\Role;
use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Command\CommandHandlerInterface;

class HandleWebHookCommandHandler implements CommandHandlerInterface
{
    /**
     * Role, used to initialise subscriber
     *
     * @var Role
     */
    private $defaultRole;

    /**
     * @var SubscribersRepositoryInterface
     */
    private $subscriberRepository;

    /**
     * @param Role $defaultRole
     * @param SubscribersRepositoryInterface $subscriberRepository
     */
    public function __construct(Role $defaultRole, SubscribersRepositoryInterface $subscriberRepository)
    {
        $this->defaultRole = $defaultRole;
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * @param HandleWebHookCommand $command
     */
    public function handle($command)
    {
        if (!$command instanceof HandleWebHookCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Request must be instance of %s',
                    HandleWebHookCommand::class
                )
            );
        }

        $request = $command->getWebHookServerRequestBody();
        $event = !empty($request['event']) ? $request['event'] : null;

        // route
        switch ($event) {
            case 'webhook':
                break;

            case 'subscribed':
            case 'conversation_started':
                if (isset($request['user']['id'])) {
                    $this->subscriberRepository->subscribe(
                        new SubscriberId($request['user']['id']),
                        $request['user']['name'],
                        $this->defaultRole
                    );
                }

                break;

            case 'unsubscribed':
                if (isset($request['user_id'])) {
                    $this->subscriberRepository->unsubscribe(new SubscriberId($request['user_id']));
                }
                break;

            default:
                throw new \InvalidArgumentException('Unsupported event');
        }
    }
}

