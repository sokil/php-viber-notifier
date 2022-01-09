<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command;

interface CommandHandlerInterface
{
    /**
     * @return mixed
     */
    public function handle($command);
}
