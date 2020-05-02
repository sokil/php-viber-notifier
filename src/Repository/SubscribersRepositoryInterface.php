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
     * @param Role $role
     */
    public function subscribe(SubscriberId $subscriberId, $subscriberName, Role $role);

    /**
     * @param SubscriberId $subscriberId
     * @param Role $role
     */
    public function updateRole(SubscriberId $subscriberId, Role $role);

    /**
     * @param string $subscriberId
     */
    public function unsubscribe(SubscriberId $subscriberId);

    /**
     * @param Role|null $role
     *
     * @return SubscriberCollection
     */
    public function findAllByRole(Role $role = null);
}