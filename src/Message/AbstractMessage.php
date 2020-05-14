<?php

namespace Sokil\Viber\Notifier\Message;

abstract class AbstractMessage
{
    /**
     * Minimal API version required by clients for this message (default 1)
     * Optional.
     * Certain features may not work as expected if set to a number that’s below their requirements.
     *
     * @return int
     */
    function getMinimalApiVersion()
    {
        return 1;
    }

    /**
     * @return string
     */
    abstract function getType();

    /**
     * @return array
     */
    abstract function toApiRequestParams();
}