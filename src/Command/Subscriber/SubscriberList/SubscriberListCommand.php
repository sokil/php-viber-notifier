<?php

namespace Sokil\Viber\Notifier\Command\Subscriber\SubscriberList;

use Sokil\Viber\Notifier\Entity\Role;

class SubscriberListCommand
{
    /**
     * @var Role|null
     */
    private $role;

    /**
     * @param Role $role
     */
    public function __construct(
        Role $role = null
    ) {
        $this->role = $role;
    }

    /**
     * @return Role|null
     */
    public function getRole()
    {
        return $this->role;
    }
}