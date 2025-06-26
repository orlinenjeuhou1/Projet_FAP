<?php

namespace App\Controller;

use App\Repository\VisitRepository;
use App\Repository\VisitTouristRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    #[Route('/api/stats/visits-by-month', methods: ['GET'])]

    public function visitsByMonth(VisitRepository $repo): JsonResponse
    {
        $data = $repo->countVisitsByMonth();
        return $this->json($data);
    }

    #[Route('/api/stats/visits-by-month-guide', methods: ['GET'])]
    #[OA\Get(
        path: '/api/stats/visits-by-month-guide',
        summary: 'Nombre de visites par guide et par mois',
        tags: ['Statistiques'],
        responses: [
            new OA\Response(response: 200, description: 'Statistiques mensuelles par guide')
        ]
    )]
    public function visitsByMonthGuide(VisitRepository $repo): JsonResponse
    {
        $data = $repo->countVisitsByMonthAndGuide();
        return $this->json($data);
    }

    #[Route('/api/stats/presence', methods: ['GET'])]
    #[OA\Get(
        path: '/api/stats/presence',
        summary: 'Taux de présence par mois',
        tags: ['Statistiques'],
        responses: [
            new OA\Response(response: 200, description: 'Taux de présence mensuel')
        ]
    )]
    public function presenceRate(VisitTouristRepository $repo): JsonResponse
    {
        $data = $repo->presenceRateByMonth();
        return $this->json($data);
    }
}


