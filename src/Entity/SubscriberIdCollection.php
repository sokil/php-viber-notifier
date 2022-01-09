<?php

declare(strict_types=1);

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

    /**
     * @return array|string[]
     */
    public function toScalarArray()
    {
        return array_map(
            function (SubscriberId $subscriberId) {
                return $subscriberId->getValue();
            },
            $this->toArray()
        );
    }
}
