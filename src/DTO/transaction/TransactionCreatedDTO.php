<?php

namespace App\DTO\transaction;

use Symfony\Component\Validator\Constraints as Assert;

class TransactionCreatedDTO
{
    public function __construct(
        #[Assert\NotBlank] #[
            Assert\Type("string")
        ]
        public readonly ?string $description,

        #[Assert\NotBlank] #[
            Assert\Type("int")
        ]
        public readonly ?int $amount,

        #[Assert\NotBlank] #[
            Assert\Type("int")
        ]
        public readonly ?int $transactionCategory,
        
    ) {}
}