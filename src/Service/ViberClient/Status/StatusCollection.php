<?php

namespace Sokil\Viber\Notifier\Service\ViberClient\Status;

use Sokil\Viber\Notifier\Tools\Structs\Collection;

/**
 * @method Status current()
 */
class StatusCollection extends Collection
{
    protected function assert($element)
    {
        if (!$element instanceof Status) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Element must be instance of %s',
                    Status::class
                )
            );
        }
    }
}