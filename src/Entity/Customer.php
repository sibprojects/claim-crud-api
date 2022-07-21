<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CustomerRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['customer:list']
            ]
        ],
        'post' => [
            'denormalization_context' => [
                'groups' => ['customer:create']
            ]
        ],
    ],
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => ['customer:item']
            ]
        ],
        'put' => [
            'normalization_context' => [
                'groups' => ['customer:item']
            ]
        ],
        'delete' => [
            'normalization_context' => [
                'groups' => ['customer:delete']
            ]
        ],
    ],
    order: [ 'Name' => 'ASC'],
    paginationEnabled: true,
    paginationItemsPerPage: 10,
)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['customer:list', 'customer:item', 'customer:delete'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['customer:list', 'customer:item', 'customer:create'])]
    private $Name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['customer:list', 'customer:item', 'customer:create'])]
    private $SSN;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: BankAccount::class, orphanRemoval: true, cascade: ["persist", "remove"])]
    #[Assert\Valid()]
    #[Groups(['customer:list','customer:item','customer:create'])]
    private $accounts;

    public function __construct()
    {
        $this->accounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getSSN(): ?string
    {
        return $this->SSN;
    }

    public function setSSN(string $SSN): self
    {
        $this->SSN = $SSN;

        return $this;
    }

    /**
     * @return Collection<int, BankAccount>
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(BankAccount $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setCustomer($this);
        }

        return $this;
    }

    public function removeAccount(BankAccount $account): self
    {
        if ($this->accounts->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getCustomer() === $this) {
                $account->setCustomer(null);
            }
        }

        return $this;
    }
}
