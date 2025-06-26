<?php

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visit>
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }

   public function countVisitsByMonth(): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT
            TO_CHAR(date, 'YYYY-MM') AS period,
            COUNT(*) AS visit_count
        FROM visit
        GROUP BY period
        ORDER BY period ASC
    ";

    $stmt = $conn->prepare($sql);
    return $stmt->executeQuery()->fetchAllAssociative();
}


   public function countVisitsByMonthAndGuide(): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT
            TO_CHAR(v.date, 'YYYY-MM') AS period,
            g.firstname AS guide,
            COUNT(v.id) AS visit_count
        FROM visit v
        JOIN guide g ON v.guide_id = g.id
        GROUP BY period, guide
        ORDER BY period ASC, guide ASC
    ";

    $stmt = $conn->prepare($sql);
    return $stmt->executeQuery()->fetchAllAssociative();
}



//    /**
//     * @return Visit[] Returns an array of Visit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Visit
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
