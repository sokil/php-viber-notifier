<?php

namespace Sokil\Viber\Notifier\Entity;

use Sokil\Viber\Notifier\Tools\Structs\Collection;

/**
 * @method Subscriber current()
 */
class SubscriberCollection extends Collection
{
    protected function assert($element)
    {
        if (!$element instanceof Subscriber) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Element must be instance of %s',
                    Subscriber::class
                )
            );
        }
    }

    /**
     * @return SubscriberIdCollection
     */
    public function getIdCollection()
    {
        return new SubscriberIdCollection(
            $this->reduce(
                function(array $carry, Subscriber $subscriber) {
                    $carry[] = $subscriber->getId();
                    return $carry;
                }
            )
        );
    }
}