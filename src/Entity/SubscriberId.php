<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Entity;

class SubscriberId
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        if (strlen($value) !== 24) {
            throw new \InvalidArgumentException('Viber subscriber id must me 24 chars long');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
