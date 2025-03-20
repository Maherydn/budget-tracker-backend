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

#[Route("/api/transaction-type", name: "transaction")]
class TransactionTypeController extends AbstractController
{
    #[
        Route(
            "/expense/{year}/{month}",
            name: ".index.expense",
            methods: ["GET"]
        )
    ]
    public function getExpenseTransaction(
        TransactionRepository $transactionsRepository,
        int $year,
        int $month
    ): Response {
        $user = $this->getUser();
        $transactions = $transactionsRepository->getExpenseTransactions(
            $year,
            $month,
            $user
        );
        return $this->json(
            $transactions,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions"]]
        );
    }

    #[Route("/income/{year}/{month}", name: ".index.income", methods: ["GET"])]
    public function getIncomeTransaction(
        TransactionRepository $transactionsRepository,
        int $year,
        int $month
    ): Response {
        $user = $this->getUser();

        $transactions = $transactionsRepository->getIncomeTransactions(
            $year,
            $month,
            $user
        );
        return $this->json(
            $transactions,
            Response::HTTP_OK,
            [],
            ["groups" => ["transactions"]]
        );
    }
}
