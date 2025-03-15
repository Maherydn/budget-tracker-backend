<?php

namespace App\DTO\transaction;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionCategoryUpdatedDTO
{
    public function __construct(
        #[Assert\Type("string")] public readonly ?string $name,

        #[Assert\Type("int")] public readonly ?int $transactionType
    ) {}
}
