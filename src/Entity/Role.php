<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Entity;

class Role
{
    /**
     * @var string
     */
    private $name;

    /**
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
