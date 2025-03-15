<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    //    /**
    //     * @return Transactions[] Returns an array of Transactions objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Transactions
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getTotalByMonth(int $year, int $month): array
    {
        return $this->createQueryBuilder("t")
            ->select("tt.name AS type", "SUM(t.amount) AS totalMontant")
            ->join("t.transactionCategory", "tc")
            ->join("tc.transactionType", "tt")
            ->where("YEAR(t.createdAt) = :year")
            ->andWhere("MONTH(t.createdAt) = :month")
            ->setParameter("year", $year)
            ->setParameter("month", $month)
            ->groupBy("tt.name")
            ->getQuery()
            ->getResult();
    }


    public function getTransactionsByMonth(int $year, int $month): array
    {
        return $this->createQueryBuilder("t")
            ->select(
                "t.id",
                "t.amount",
                "t.createdAt",
                "tc.name AS categorie",
                "tt.name AS type"
            )
            ->join("t.category", "tc")
            ->join("tc.transactionType", "tt")
            ->where("YEAR(t.createdAt) = :year")
            ->andWhere("MONTH(t.createdAt) = :month")
            ->setParameter("year", $year)
            ->setParameter("month", $month)
            ->orderBy("t.createdAt", "DESC")
            ->getQuery()
            ->getResult();
    }
}
