<?php

namespace Sokil\Viber\Notifier\Command\Subscriber\SetRole;

use Sokil\Viber\Notifier\Entity\Role;
use Sokil\Viber\Notifier\Entity\SubscriberId;

class SetSubscriptionRoleCommand
{
    /**
     * @var SubscriberId
     */
    private $subscriberId;

    /**
     * @var Role
     */
    private $role;

    /**
     * @param SubscriberId $subscriberId
     * @param Role $role
     */
    public function __construct(
        SubscriberId $subscriberId,
        Role $role
    ) {
        $this->subscriberId = $subscriberId;
        $this->role = $role;
    }

    /**
     * @return SubscriberId
     */
    public function getSubscriberId()
    {
        return $this->subscriberId;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}