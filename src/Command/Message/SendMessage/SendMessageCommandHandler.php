<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\Message\SendMessage;

use Sokil\Viber\Notifier\Command\CommandHandlerInterface;
use Sokil\Viber\Notifier\Service\ViberClient\Status\StatusCollection;
use Sokil\Viber\Notifier\Service\ViberClient\ViberClientInterface;

class SendMessageCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ViberClientInterface
     */
    private $viberClient;

    /**
     */
    public function __construct(ViberClientInterface $viberClient)
    {
        $this->viberClient = $viberClient;
    }

    /**
     *
     * @return StatusCollection
     */
    public function handle($command)
    {
        if (!$command instanceof SendMessageCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Request must be instance of %s',
                    SendMessageCommand::class
                )
            );
        }

        if (count($command->getSubscriberIdCollection()) === 1) {
            $status = $this->viberClient->sendMessage(
                $command->getSenderName(),
                $command->getMessage(),
                $command->getSubscriberIdCollection()->current()
            );

            $statusCollection = new StatusCollection([$status]);
        } else {
            $statusCollection = $this->viberClient->broadcastMessage(
                $command->getSenderName(),
                $command->getMessage(),
                $command->getSubscriberIdCollection()
            );
        }


        return $statusCollection;
    }
}
