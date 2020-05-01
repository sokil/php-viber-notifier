<?php

namespace Sokil\Viber\Notifier\Command;

interface CommandHandlerInterface
{
    /**
     * @return mixed
     */
    public function handle($command);
}
