<?php

namespace Sokil\Viber\Notifier\Command\Subscriber\SubscriberList;

use Sokil\Viber\Notifier\Entity\RoleCollection;

class SubscriberListCommand
{
    /**
     * @var RoleCollection|null
     */
    private $roles;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @param RoleCollection|null $roles
     * @param int $limit
     * @param int $offset
     */
    public function __construct(
        RoleCollection $roles = null,
        $limit = 100,
        $offset = 0
    ) {
        if ($limit < 1) {
            throw new \InvalidArgumentException('Limit must be positive');
        }

        if ($offset < 0) {
            throw new \InvalidArgumentException('Offset must be positive or 0');
        }

        $this->roles = $roles;
        $this->limit = $limit;
        $this->offset = $offset;
    }


    /**
     * @return RoleCollection|null
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }
}