<?php

namespace App\DTO\transaction;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionCategoryCreatedDTO
{
    public function __construct(
        #[Assert\NotBlank] #[
            Assert\Type("string")
        ]
        public readonly ?string $name,

        #[Assert\NotBlank] #[
            Assert\Type("int")
        ]
        public readonly ?int $transactionType,
        
    ) {}
}