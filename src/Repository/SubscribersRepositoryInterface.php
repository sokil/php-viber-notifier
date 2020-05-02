<?php

namespace Sokil\Viber\Notifier\Repository;

use Sokil\Viber\Notifier\Entity\Role;
use Sokil\Viber\Notifier\Entity\SubscriberCollection;
use Sokil\Viber\Notifier\Entity\SubscriberId;

interface SubscribersRepositoryInterface
{
    /**
     * @param SubscriberId $subscriberId
     * @param string $subscriberName
     */
    public function subscribe(SubscriberId $subscriberId, $subscriberName);

    /**
     * @param string $subscriberId
     */
    public function unsubscribe(SubscriberId $subscriberId);

    /**
     * @param Role|null $role
     * @param int $limit
     * @param int $offset
     *
     * @return SubscriberCollection
     */
    public function findAllByRole(
        Role $role = null,
        $limit,
        $offset
    );
}