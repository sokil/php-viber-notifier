<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\Result;

use Sokil\Viber\Notifier\Entity\SubscriberIdCollection;
use Sokil\Viber\Notifier\Tools\Structs\Collection;

class SubscriberList extends Collection
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
    public function getSubscriberIdCollection()
    {
        return new SubscriberIdCollection(
            $this->reduce(
                function (array $carry, Subscriber $subscriber) {
                    $carry[] = $subscriber->getId();
                    return $carry;
                }
            )
        );
    }
}
