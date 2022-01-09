<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Entity;

class SubscriberId
{
    /**
     * @var string
     */
    private $value;

    /**
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
