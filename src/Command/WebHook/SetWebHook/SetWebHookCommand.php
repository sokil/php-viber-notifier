<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\WebHook\SetWebHook;

class SetWebHookCommand
{
    /**
     * @var string
     */
    private $url;

    /**
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
