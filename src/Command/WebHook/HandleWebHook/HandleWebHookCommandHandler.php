<?php

namespace Sokil\Viber\Notifier\Command\WebHook\HandleWebHook;

use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Command\CommandHandlerInterface;

class HandleWebHookCommandHandler implements CommandHandlerInterface
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
            case 'seen':
            case 'action':
            case 'delivered':
            case 'failed':
            case 'message':
                break;

            case 'subscribed':
            case 'conversation_started':
                if (isset($request['user']['id'])) {
                    $this->subscriberRepository->subscribe(
                        new SubscriberId($request['user']['id']),
                        $request['user']['name']
                    );
                }

                break;

            case 'unsubscribed':
                if (isset($request['user_id'])) {
                    $this->subscriberRepository->unsubscribe(new SubscriberId($request['user_id']));
                }
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Unsupported event "%s"', $event));
        }
    }
}

