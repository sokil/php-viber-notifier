<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Command\Subscriber\SubscriberList\Result;

use Sokil\Viber\Notifier\Entity\SubscriberId;

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
     */
    public function __construct(SubscriberId $id, string $name)
    {
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
