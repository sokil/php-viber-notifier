<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Entity;

use Sokil\Viber\Notifier\Tools\Structs\Collection;

/**
 * @method Role current()
 * @method Role get()
 */
class RoleCollection extends Collection
{
    protected function assert($element)
    {
        if (!$element instanceof Role) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Element must be instance of %s',
                    Role::class
                )
            );
        }
    }
}
