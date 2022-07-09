<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BankAccountRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Classes\AccountType;
use App\Classes\Validator\AccountNumberCheck;

#[ORM\Entity(repositoryClass: BankAccountRepository::class)]
class BankAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 11)]
    #[Assert\Length(
        min: 11,
        max: 11,
        exactMessage: 'Account number must be a string of {{ limit }} character',
    )]
    #[Groups(['customer:list','customer:item','customer:create'])]
    private $AccountNumber;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Choice(callback: [AccountType::class, 'getTypes'], message: 'Choose a valid AccountType: {{ choices }}')]
    #[Groups(['customer:list','customer:item','customer:create'])]
    private $AccountType;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['customer:list','customer:item','customer:create'])]
    private $AccountName;

    #[ORM\Column(type: 'string', length: 3)]
    #[Assert\Currency]
    #[Groups(['customer:list','customer:item','customer:create'])]
    private $Currency;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'accounts')]
    #[ORM\JoinColumn(nullable: false)]
    private $customer;

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
        if(!AccountNumberCheck::validate($this->getAccountNumber())){
            $context->buildViolation('Account number is not correspond to MOD11 algorithm')
                ->atPath('accountNumber')
                ->addViolation();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountNumber(): ?string
    {
        return $this->AccountNumber;
    }

    public function setAccountNumber(string $AccountNumber): self
    {
        $this->AccountNumber = $AccountNumber;

        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->AccountType;
    }

    public function setAccountType(string $AccountType): self
    {
        $this->AccountType = $AccountType;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->AccountName;
    }

    public function setAccountName(string $AccountName): self
    {
        $this->AccountName = $AccountName;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->Currency;
    }

    public function setCurrency(string $Currency): self
    {
        $this->Currency = $Currency;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }
}
