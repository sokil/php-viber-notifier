<?php

declare(strict_types=1);

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
     */
    public function __construct(
        RoleCollection $roles = null,
        int $limit = 100,
        int $offset = 0
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
