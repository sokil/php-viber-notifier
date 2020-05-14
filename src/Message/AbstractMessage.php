<?php

namespace Sokil\Viber\Notifier\Message;

abstract class AbstractMessage
{
    /**
     * @return string
     */
    abstract function getType();

    /**
     * @return array
     */
    abstract function toApiRequestParams();
}