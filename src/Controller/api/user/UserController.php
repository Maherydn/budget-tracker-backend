<?php

namespace App\Controller\api\user;

use App\DTO\UserCreatedDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/user", name: "user")]
class UserController extends AbstractController
{
    #[Route("/create", name: ".create", methods: ["POST"])]
    public function createUser(
        #[MapRequestPayload] UserCreatedDTO $userCreateDTO,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = new User();

        $userProps = [
            "email" => "setEmail",
            "username" => "setUsername",
            "roles" => "setRoles",
        ];

        foreach ($userProps as $prop => $setter) {
            $value = $userCreateDTO->$prop;

            if ($value !== null && $value !== "") {
                if ($prop === "roles" && !is_array($value)) {
                    return $this->json(
                        ["error" => "Le champ roles doit être un tableau."],
                        Response::HTTP_BAD_REQUEST
                    );
                }
                $user->$setter($value);
            }
        }

        // Pour mdp
        if (
            isset($userCreateDTO->password) &&
            !empty($userCreateDTO->password)
        ) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $userCreateDTO->password
            );
            $user->setPassword($hashedPassword);
        }

        $em->persist($user);
        $em->flush();

        return $this->json(
            $user,
            Response::HTTP_OK,
            [],
            [
                "groups" => ["user"],
            ]
        );
    }

    #[Route("/", name: ".read", methods: ["GET"])]
    public function findUser(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->json($users, Response::HTTP_OK, [], []);
    }
}
