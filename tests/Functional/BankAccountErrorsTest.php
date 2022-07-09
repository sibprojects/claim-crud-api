<?php

namespace App\Tests\Functional;

use Symfony\Component\Validator\Validation;
use PHPUnit\Framework\TestCase;
use App\Entity\BankAccount;

class BankAccountErrorsTest extends TestCase
{
    protected $object;
    protected $validator;

    protected function setUp(): void
    {
        $this->object = new BankAccount();
        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    public function testBankAccountParams(): void
    {
        // test Account Number errors
        $this->object->setAccountNumber('123');
        $errors = $this->validator->validate($this->object);
        $this->assertEquals(2, count($errors));
        $this->assertEquals('Account number is not correspond to MOD11 algorithm', $errors[0]->getMessage());
        $this->assertEquals('Account number must be a string of 11 character', $errors[1]->getMessage());

        // test Account number success
        $this->object->setAccountNumber('11111111111');
        $errors = $this->validator->validate($this->object);
        $this->assertEquals(0, count($errors));

        // test Account Type errors
        $this->object->setAccountType('NO_VALUE');
        $errors = $this->validator->validate($this->object);
        $this->assertEquals(1, count($errors));
        $this->assertEquals('Choose a valid AccountType: "ORGANIZATION", "PRIVATE"', $errors[0]->getMessage());

        // test Account Type success
        $this->object->setAccountType('PRIVATE');
        $errors = $this->validator->validate($this->object);
        $this->assertEquals(0, count($errors));

        // test Currency errors
        $this->object->setCurrency('TMP');
        $errors = $this->validator->validate($this->object);
        $this->assertEquals(1, count($errors));
        $this->assertEquals('This value is not a valid currency.', $errors[0]->getMessage());

        $this->object->setCurrency('USD');
        $errors = $this->validator->validate($this->object);
        $this->assertEquals(0, count($errors));
    }
}
