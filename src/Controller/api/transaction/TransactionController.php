<?php

namespace App\Controller\api\transaction;

use App\DTO\transaction\TransactionCreatedDTO;
use App\DTO\transaction\TransactionUpdatedDTO;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use App\Service\transaction\TransactionService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/transaction", name: "transaction")]
class TransactionController extends AbstractController
{
    #[Route("/create", name: ".create", methods: ["POST"])]
    public function createTransactions(
        #[MapRequestPayload] TransactionCreatedDTO $transactionCreateDTO,
        EntityManagerInterface $em,
        TransactionService $transactionService
    ): Response {
        $transaction = $transactionService->createTransactionFromDTO(
            $transactionCreateDTO
        );

        $transaction->setUser($this->getUser());
        $transaction->setCreatedAtValue();

        $em->persist($transaction);
        $em->flush();

        return $this->json(
            $transaction,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions"]]
        );
    }

    #[Route("/", name: ".index", methods: ["GET"])]
    public function index(
        TransactionRepository $transactionsRepository
    ): Response {
        $transactions = $transactionsRepository->findAll();
        return $this->json(
            $transactions,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions"]]
        );
    }

    #[Route("/{id}", name: ".show", methods: ["GET"])]
    public function show(Transaction $transaction): Response
    {
        return $this->json(
            $transaction,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions"]]
        );
    }

    #[Route("/update/{id}", name: ".update", methods: ["POST"])]
    public function updateTransactions(
        #[MapRequestPayload] TransactionUpdatedDTO $transactionUpdatedDTO,
        EntityManagerInterface $em,
        TransactionService $transactionService,
        Transaction $transactions
    ): Response {
        $transaction = $transactionService->updateTransactionFromDTO(
            $transactions,
            $transactionUpdatedDTO
        );
        $em->flush();

        return $this->json(
            $transaction,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions"]]
        );
    }
}
