<?php

namespace Sokil\Viber\Notifier\Command\Message\SendMessage;

use Sokil\Viber\Notifier\Command\CommandHandlerInterface;
use Sokil\Viber\Notifier\Service\ViberClient\ViberClientInterface;

class SendMessageCommandHandler implements CommandHandlerInterface
{
    /**
     * @var ViberClientInterface
     */
    private $viberClient;

    /**
     * @param ViberClientInterface $viberClient
     */
    public function __construct(ViberClientInterface $viberClient)
    {
        $this->viberClient = $viberClient;
    }

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
            $command->getSubscriberIdCollection()
        );

        return $response;
    }
}



