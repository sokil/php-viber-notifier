<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\WebHook\HandleWebHook;

use PHPUnit\Framework\TestCase;
use Sokil\Viber\Notifier\Command\WebHook\SetWebHook\SetWebHookCommand;
use Sokil\Viber\Notifier\Command\WebHook\SetWebHook\SetWebHookCommandHandler;
use Sokil\Viber\Notifier\Service\ViberClient\ViberClientInterface;

class SetWebHookCommandHandlerTest extends TestCase
{
    public function testSetWebHook()
    {
        $webHookUrl = 'http://server.com/viberWebHook';

        $command = new SetWebHookCommand(
            $webHookUrl
        );

        $viberClient = $this->getMockBuilder(ViberClientInterface::class)->getMock();
        $viberClient
            ->expects($this->once())
            ->method('setWebHookUrl')
            ->with($webHookUrl);

        $commandHandler = new SetWebHookCommandHandler(
            $viberClient
        );

        $commandHandler->handle($command);
    }
}
