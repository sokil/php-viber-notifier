<?php

namespace Sokil\Viber\Notifier\Command\Message\SendMessage;

use Sokil\Viber\Notifier\Command\CommandHandlerInterface;
use Sokil\Viber\Notifier\Service\ViberClient\ViberClient;

class SendMessageCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ViberClient
     */
    private $viberClient;

    /**
     * @param SendMessageCommand $command
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

        $response = $this->viberClient->broadcastMessage(
            $command->getSenderName(),
            $command->getText(),
            $command->getRole()
        );

        return $response;
    }
}



