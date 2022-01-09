<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\WebHook\HandleWebHook;

use Sokil\Viber\Notifier\Entity\SubscriberId;
use Sokil\Viber\Notifier\Repository\SubscribersRepositoryInterface;
use Sokil\Viber\Notifier\Command\CommandHandlerInterface;

/**
 * @link https://developers.viber.com/docs/api/rest-bot-api/#callbacks
 */
class HandleWebHookCommandHandler implements CommandHandlerInterface
{
    /**
     * @var SubscribersRepositoryInterface
     */
    private $subscriberRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     */
    public function __construct(
        SubscribersRepositoryInterface $subscriberRepository,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->subscriberRepository = $subscriberRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     */
    public function handle(HandleWebHookCommand $command)
    {
        if (!$command instanceof HandleWebHookCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Request must be instance of %s',
                    HandleWebHookCommand::class
                )
            );
        }

        $webHookServerRequestBody = $command->getWebHookServerRequestBody();
        $eventName = !empty($webHookServerRequestBody['event']) ? $webHookServerRequestBody['event'] : null;

        // dispatch event
        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch($eventName, $webHookServerRequestBody);
        }

        // route
        switch ($eventName) {
            case 'webhook':
            case 'seen':
            case 'action':
            case 'delivered':
            case 'failed':
            case 'message':
                break;

            case 'subscribed':
            case 'conversation_started':
                if (isset($webHookServerRequestBody['user']['id'])) {
                    $this->subscriberRepository->subscribe(
                        new SubscriberId($webHookServerRequestBody['user']['id']),
                        $webHookServerRequestBody['user']['name']
                    );
                }

                break;

            case 'unsubscribed':
                if (isset($webHookServerRequestBody['user_id'])) {
                    $this->subscriberRepository->unsubscribe(new SubscriberId($webHookServerRequestBody['user_id']));
                }
                break;

            default:
                throw new \InvalidArgumentException(sprintf('Unsupported event "%s"', $eventName));
        }
    }
}
