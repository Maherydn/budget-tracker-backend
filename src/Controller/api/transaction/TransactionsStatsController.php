<?php

namespace App\Controller\api\transaction;

use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transactions/stats')]
class TransactionsStatsController extends AbstractController
{
    #[Route('/total/{year}/{month}', name: 'app_transaction_total_by_month', methods: ['GET'])]
    public function getTotalByMonth(TransactionRepository $transactionRepository, int $year, int $month): JsonResponse
    {
        $totals = $transactionRepository->getTotalByMonth($year, $month);
        return $this->json($totals);
    }

    #[Route('/{year}/{month}', name: 'app_transactions_by_month', methods: ['GET'])]
    public function getTransactionsByMonth(TransactionRepository $transactionRepository, int $year, int $month): JsonResponse
    {
        $transactions = $transactionRepository->getTransactionsByMonth($year, $month);
        return $this->json($transactions);
    }
}
