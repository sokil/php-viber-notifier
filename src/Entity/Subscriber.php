<?php

namespace Sokil\Viber\Notifier\Entity;

class Subscriber
{
    /**
     * @var SubscriberId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var RoleCollection
     */
    private $roleCollection;

    /**
     * @param SubscriberId $id
     * @param string $name
     * @param RoleCollection $roleCollection
     */
    public function __construct(
        SubscriberId $id,
        $name,
        RoleCollection $roleCollection
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->roleCollection = $roleCollection;
    }

    /**
     * @return SubscriberId
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return RoleCollection
     */
    public function getRoleCollection()
    {
        return $this->roleCollection;
    }
}