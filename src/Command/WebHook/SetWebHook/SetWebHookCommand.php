<?php

namespace Sokil\Viber\Notifier\Command\WebHook\SetWebHook;

class SetWebHookCommand
{
    /**
     * @var string
     */
    private $url;

    /**
     * SetWebHookCommand constructor.
     * @param string $url
     */
    public function __construct($url)
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