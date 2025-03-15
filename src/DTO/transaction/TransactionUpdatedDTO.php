<?php

namespace App\DTO\transaction;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionUpdatedDTO
{
    public function __construct(
        #[Assert\Type("string")] public readonly ?string $description,

        #[Assert\Type("int")] public readonly ?int $amount,

        #[Assert\Type("int")] public readonly ?int $transactionCategory
    ) {}
}
