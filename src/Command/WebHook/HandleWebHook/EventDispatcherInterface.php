<?php

namespace Sokil\Viber\Notifier\Command\WebHook\HandleWebHook;

interface EventDispatcherInterface
{
    /**
     * @param $eventName
     * @param array $payload
     *
     * @return void
     */
    public function dispatch($eventName, array $payload);

    /**
     * @param $eventName
     * @param $callable
     *
     * @return void
     */
    public function addListener($eventName, $callable);
}