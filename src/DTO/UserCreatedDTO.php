<?php

namespace App\DTO;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class UserCreatedDTO
{
    public function __construct(
        #[Assert\NotBlank] #[
            Assert\Type("string")
        ]
        public readonly ?string $email,

        #[Assert\NotBlank] #[
            Assert\Type("string")
        ]
        public readonly ?string $password,

        #[Assert\NotBlank] #[
            Assert\Type("string")
        ]
        public readonly ?string $username,
        
        #[Assert\Type("array")] public readonly ?array $roles
    ) {}
}