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
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @param Role|null $role
     * @param int $limit
     * @param int $offset
     */
    public function __construct(Role $role = null, $limit = 100, $offset = 0)
    {
        if ($limit < 1) {
            throw new \InvalidArgumentException('Limit must be positive');
        }

        if ($offset < 0) {
            throw new \InvalidArgumentException('Offset must be positive or 0');
        }

        $this->role = $role;
        $this->limit = $limit;
        $this->offset = $offset;
    }


    /**
     * @return Role|null
     */
    public function getRole()
    {
        return $this->role;
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