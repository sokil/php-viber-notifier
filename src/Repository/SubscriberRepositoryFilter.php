<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Repository;

use Sokil\Viber\Notifier\Entity\RoleCollection;

class SubscriberRepositoryFilter
{
    /**
     * @var RoleCollection
     */
    private $roles;

    /**
     * @var bool
     */
    private $active;

    /**
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

    public function setActive()
    {
        $this->active = true;
    }

    public function setDisabled()
    {
        $this->active = false;
    }

    /**
     * @return bool|null, nul if any, true if active, false if disabled
     */
    public function getActive()
    {
        return $this->active;
    }
}
