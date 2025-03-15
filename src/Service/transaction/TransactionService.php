<?php

namespace App\Service\transaction;

use App\DTO\transaction\TransactionCreatedDTO;
use App\DTO\transaction\TransactionUpdatedDTO;
use App\Entity\Transaction;
use App\Repository\TransactionCategoryRepository;

class TransactionService
{
    private TransactionCategoryRepository $categoryRepository;

    public function __construct(
        TransactionCategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    public function createTransactionFromDTO(
        TransactionCreatedDTO $transactionCreateDTO
    ): Transaction {
        return $this->mapDTOToTransaction(
            new Transaction(),
            $transactionCreateDTO
        );
    }

    public function updateTransactionFromDTO(
        Transaction $transaction,
        TransactionUpdatedDTO $transactionUpdatedDTO
    ): Transaction {
        return $this->mapDTOToTransaction(
            $transaction,
            $transactionUpdatedDTO
        );
    }

    private function mapDTOToTransaction(
        Transaction $transaction,
        object $dto
    ): Transaction {
        $repositories = [
            "transactionCategory" => $this->categoryRepository,
        ];

        $properties = [
            "amount" => "setAmount",
            "transactionCategory"=> "setTransactionCategory",
            "description" => "setDescription",
        ];

        foreach ($properties as $prop => $setter) {
            if (!property_exists($dto, $prop)) {
                continue;
            }

            $value = $dto->$prop;

            if (isset($repositories[$prop]) && $value !== null) {
                $entity = $repositories[$prop]->find($value);
                $transaction->$setter($entity);
            } elseif ($value !== null && $value !== "") {
                $transaction->$setter($value);
            }
        }

        return $transaction;
    }
}
