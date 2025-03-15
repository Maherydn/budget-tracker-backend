<?php

namespace App\Entity;

use App\Repository\TransactionTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TransactionTypeRepository::class)]
class TransactionType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['transactions.types'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['transactions', 'transactions.types'])]
    private ?string $name = null;

    /**
     * @var Collection<int, TransactionCategory>
     */
    #[ORM\OneToMany(targetEntity: TransactionCategory::class, mappedBy: 'transactionType')]
    private Collection $transactionCategories;

    public function __construct()
    {
        $this->transactionCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, TransactionCategory>
     */
    public function getTransactionCategories(): Collection
    {
        return $this->transactionCategories;
    }

    public function addTransactionCategory(TransactionCategory $transactionCategory): static
    {
        if (!$this->transactionCategories->contains($transactionCategory)) {
            $this->transactionCategories->add($transactionCategory);
            $transactionCategory->setTransactionType($this);
        }
        return $this;
    }

    public function removeTransactionCategory(TransactionCategory $transactionCategory): static
    {
        if ($this->transactionCategories->removeElement($transactionCategory)) {
            if ($transactionCategory->getTransactionType() === $this) {
                $transactionCategory->setTransactionType(null);
            }
        }
        return $this;
    }
}
