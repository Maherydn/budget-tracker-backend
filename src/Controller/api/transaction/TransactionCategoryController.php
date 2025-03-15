<?php

namespace App\Controller\api\transaction;


use App\DTO\transaction\TransactionCategoryCreatedDTO;
use App\DTO\transaction\TransactionCategoryUpdatedDTO;
use App\Entity\TransactionCategory;
use App\Repository\TransactionCategoryRepository;
use App\Service\transaction\TransactionCategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Doctrine\ORM\EntityManagerInterface;

#[Route("/transactions-category", name: "transactions-types")]
class TransactionCategoryController extends AbstractController
{
    #[Route(path: "/create", name: ".create", methods: ["POST"])]
    public function createTypes(
        #[
            MapRequestPayload
        ]
        TransactionCategoryCreatedDTO $transactionCategoryCreatedDTO,
        TransactionCategoryService $transactionsCategoryService,
        EntityManagerInterface $em
    ): Response {
        $transactionCategory = $transactionsCategoryService->createTransactionCategoryFromDTO(
            $transactionCategoryCreatedDTO
        );

        $em->persist($transactionCategory);
        $em->flush();
        return $this->json(
            $transactionCategory,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions.types"]]
        );
    }

    #[Route("/", name: ".index", methods: ["GET"])]
    public function index(
        TransactionCategoryRepository $transactionCategoryRepository
    ): Response {
        $transactionCategory = $transactionCategoryRepository->findAll();
        return $this->json(
            $transactionCategory,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions.types"]]
        );
    }

    #[Route("/{id}", name: ".show", methods: ["GET"])]
    public function show(TransactionCategory $transactionCategory): Response
    {
        return $this->json(
            $transactionCategory,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions.types"]]
        );
    }

    #[Route("/update/{id}", name: ".update", methods: ["POST"])]
    public function updateTransactions(
        #[
            MapRequestPayload
        ]
        TransactionCategoryUpdatedDTO $transactionCategoryUpdatedDTO,
        EntityManagerInterface $em,
        TransactionCategoryService $transactionsCategoryService,
        TransactionCategory $transactionCategory
    ): Response {
        $transactionCategory = $transactionsCategoryService->updateTransactionCategoryFromDTO(
            $transactionCategory,
            $transactionCategoryUpdatedDTO
        );
        $em->flush();

        return $this->json(
            $transactionCategoryUpdatedDTO,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions.types"]]
        );
    }
}
