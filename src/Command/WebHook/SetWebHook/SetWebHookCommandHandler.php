<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\WebHook\SetWebHook;

use Sokil\Viber\Notifier\Command\WebHook\HandleWebHook\HandleWebHookCommand;
use Sokil\Viber\Notifier\Command\CommandHandlerInterface;
use Sokil\Viber\Notifier\Service\ViberClient\ViberClientInterface;

class SetWebHookCommandHandler implements CommandHandlerInterface
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
     */
    public function handle(HandleWebHookCommand $command)
    {
        if (!$command instanceof SetWebHookCommand) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Request must be instance of %s',
                    SetWebHookCommand::class
                )
            );
        }

        $response = $this->viberClient->setWebHookUrl($command->getUrl());

        return $response;
    }
}
