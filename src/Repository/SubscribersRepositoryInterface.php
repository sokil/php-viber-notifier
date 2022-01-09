<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Repository;

use Sokil\Viber\Notifier\Entity\Role;
use Sokil\Viber\Notifier\Entity\SubscriberCollection;
use Sokil\Viber\Notifier\Entity\SubscriberId;

interface SubscribersRepositoryInterface
{
    /**
     */
    public function subscribe(SubscriberId $subscriberId, string $subscriberName);

    /**
     * @param string $subscriberId
     */
    public function unsubscribe(SubscriberId $subscriberId);

    /**
     *
     * @return SubscriberCollection
     */
    public function findAll(
        SubscriberRepositoryFilter $filter,
        int $limit,
        int $offset
    );
}
