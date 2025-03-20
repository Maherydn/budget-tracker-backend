<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["transactions"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["transactions"])]
    private ?int $amount = null;

    #[ORM\Column(length: 255)]
    #[Groups(["transactions"])]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(["transactions"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: TransactionCategory::class, inversedBy: 'transactions', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["transactions"])]
    private ?TransactionCategory $transactionCategory = null;

    #[ORM\ManyToOne(inversedBy: 'transaction')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if ($this->createdAt === null) {
            $this->createdAt = new \DateTimeImmutable();
        }
    }

    public function getTransactionCategory(): ?TransactionCategory
    {
        return $this->transactionCategory;
    }

    public function setTransactionCategory(?TransactionCategory $transactionCategory): static
    {
        $this->transactionCategory = $transactionCategory;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
