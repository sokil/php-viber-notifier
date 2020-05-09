<?php

namespace Sokil\Viber\Notifier\Repository;

use Sokil\Viber\Notifier\Entity\RoleCollection;

class SubscriberRepositoryFilter
{
    /**
     * @var RoleCollection
     */
    private $roles;

    /**
     * @param RoleCollection $roles
     *
     * @return self
     */
    public function setRoles(RoleCollection $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return RoleCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}