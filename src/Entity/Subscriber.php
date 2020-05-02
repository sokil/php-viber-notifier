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
     * @param SubscriberId $id
     * @param string $name
     */
    public function __construct(
        SubscriberId $id,
        $name
    ) {
        $this->id = $id;
        $this->name = $name;
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
}