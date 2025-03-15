<?php

namespace App\Service\transaction;

use App\DTO\transaction\TransactionCategoryCreatedDTO;
use App\DTO\transaction\TransactionCategoryUpdatedDTO;
use App\Entity\TransactionCategory;
use App\Repository\TransactionTypeRepository;

class TransactionCategoryService
{
    private TransactionTypeRepository $transactionTypeRepository;

    public function __construct(
        TransactionTypeRepository $transactionTypeRepository
    ) {
        $this->transactionTypeRepository = $transactionTypeRepository;
    }

    public function createTransactionCategoryFromDTO(
        TransactionCategoryCreatedDTO $transactionCategoryCreatedDTO
    ): TransactionCategory {
        return $this->mapDTOToTransactions(
            new TransactionCategory(),
            $transactionCategoryCreatedDTO
        );
    }

    public function updateTransactionCategoryFromDTO(
        TransactionCategory $transactionCategory,
        TransactionCategoryUpdatedDTO $transactionCategoryUpdatedDTO
    ): TransactionCategory {
        return $this->mapDTOToTransactions(
            $transactionCategory,
            $transactionCategoryUpdatedDTO
        );
    }

    private function mapDTOToTransactions(
        TransactionCategory $transactionCategory,
        object $dto
    ): TransactionCategory {
        $repositories = [
            "transactionType" => $this->transactionTypeRepository,
        ];

        $properties = [
            "name" => "setName",
            "transactionType"=> "setTransactionType"
        ];

        foreach ($properties as $prop => $setter) {
            if (!property_exists($dto, $prop)) {
                continue;
            }

            $value = $dto->$prop;

            if (isset($repositories[$prop]) && $value !== null) {
                $entity = $repositories[$prop]->find($value);
                $transactionCategory->$setter($entity);
            } elseif ($value !== null && $value !== "") {
                $transactionCategory->$setter($value);
            }
        }

        return $transactionCategory;
    }
}
