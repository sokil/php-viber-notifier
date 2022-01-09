<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\WebHook\HandleWebHook;

class HandleWebHookCommand
{
    /**
     * @var array
     */
    private $webHookServerRequestBody;

    /**
     * @param array $webHookServerRequestBody
     */
    public function __construct(array $webHookServerRequestBody)
    {
        $this->webHookServerRequestBody = $webHookServerRequestBody;
    }

    /**
     * @return array
     */
    public function getWebHookServerRequestBody()
    {
        return $this->webHookServerRequestBody;
    }
}
