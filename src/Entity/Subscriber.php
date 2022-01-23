<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Entity;

class Subscriber
{
    /**
     * @var SubscriberId
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     */
    public function __construct(
        SubscriberId $id,
        string $name
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
