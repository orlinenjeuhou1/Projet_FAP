<?php

namespace App\Repository;

use App\Entity\VisitTourist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VisitTourist>
 */
class VisitTouristRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisitTourist::class);
    }

    /**
     * Retourne le taux de présence par mois (en %)
     */
   public function presenceRateByMonth(): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT
            TO_CHAR(v.date, 'YYYY-MM') AS period,
            COUNT(*) AS total,
            SUM(CASE WHEN vt.present THEN 1 ELSE 0 END) AS present_count,
            ROUND(SUM(CASE WHEN vt.present THEN 1 ELSE 0 END) * 100.0 / COUNT(*), 2) AS presence_rate
        FROM visit_tourist vt
        INNER JOIN visit v ON vt.visit_id = v.id
        GROUP BY period
        ORDER BY period ASC
    ";

    $stmt = $conn->prepare($sql);
    return $stmt->executeQuery()->fetchAllAssociative();
}
}

