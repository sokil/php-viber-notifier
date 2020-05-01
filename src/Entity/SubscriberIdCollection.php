<?php

namespace Sokil\Viber\Notifier\Entity;

use Sokil\Viber\Notifier\Tools\Structs\Collection;

/**
 * @method SubscriberId current()
 */
class SubscriberIdCollection extends Collection
{
    protected function assert($element)
    {
        if (!$element instanceof SubscriberId) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Element must be instance of %s',
                    SubscriberId::class
                )
            );
        }
    }
}