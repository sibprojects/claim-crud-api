<?php

namespace App\Tests\Entity;

use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        $this->object = new Customer();
    }

    public function testCustomer(): void
    {
        $this->assertNull($this->object->getId());

        $this->object->setName("Tom Sumkin");
        $this->assertEquals("Tom Sumkin", $this->object->getName());

        $this->object->setSSN("111111111");
        $this->assertEquals("111111111", $this->object->getSSN());
    }
}
