<?php

declare(strict_types=1);

namespace Sokil\Viber\Notifier\Tools\Structs;

use PHPUnit\Framework\TestCase;
use Sokil\Viber\Notifier\Entity\Role;
use Sokil\Viber\Notifier\Entity\RoleCollection;

class CollectionTest extends TestCase
{
    public function testGet()
    {
        $roleCollection = new RoleCollection([
            new Role('role0'),
            new Role('role1'),
            new Role('role2'),
            new Role('role3'),
        ]);

        $this->assertSame('role2', $roleCollection->get(2)->getName());
    }
}
