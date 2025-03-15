<?php
// src/Security/UserProvider.php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        // Try to load user by email first
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $identifier]);

        if (!$user) {
            // If email not found, try with username
            $user = $this->entityManager->getRepository(User::class)
                ->findOneBy(['username' => $identifier]);

            // if (!$user) {
            //     throw new UsernameNotFoundException(
            //         sprintf('User "%s" not found.', $identifier)
            //     );
            // }
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        // Ensure the user entity is fresh
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }
}
