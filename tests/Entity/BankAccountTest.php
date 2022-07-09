<?php

namespace App\Tests\Entity;

use App\Entity\BankAccount;
use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class BankAccountTest extends TestCase
{
    protected $object;
    protected $customer;

    protected function setUp(): void
    {
        $this->object = new BankAccount();
        $this->car = new Customer();
    }

    public function testBankAccount(): void
    {
        $this->car->setName("Tom Sumkin");
        $this->car->setSSN("123123123");

        $this->assertNull($this->object->getId());

        $this->object->setCustomer($this->customer);
        $this->assertEquals($this->customer, $this->object->getCustomer());

        $this->object->setAccountNumber('11111111111');
        $this->assertEquals('11111111111', $this->object->getAccountNumber());

        $this->object->setAccountType('PRIVATE');
        $this->assertEquals('PRIVATE', $this->object->getAccountType());

        $this->object->setAccountName('My Account');
        $this->assertEquals('My Account', $this->object->getAccountName());

        $this->object->setCurrency('USD');
        $this->assertEquals('USD', $this->object->getCurrency());
    }
}
