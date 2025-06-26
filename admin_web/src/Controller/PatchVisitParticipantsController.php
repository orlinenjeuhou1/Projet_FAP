<?php

namespace App\Controller;

use App\Repository\VisitRepository;
use App\Repository\VisitTouristRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class PatchVisitParticipantsController extends AbstractController
{
    public function __invoke(Request $request, VisitRepository $visitRepo, VisitTouristRepository $vtRepo, EntityManagerInterface $em): JsonResponse
    {
        $id = $request->attributes->get('id');
        $visit = $visitRepo->find($id);

        if (!$visit) {
            return $this->json(['error' => 'Visite introuvable'], 404);
        }

        try {
            $data = json_decode($request->getContent(), true);
            foreach ($data['participants'] ?? [] as $item) {
                $vt = $vtRepo->find($item['id'] ?? 0);
                if ($vt && $vt->getVisit()->getId() === $visit->getId()) {
                    $vt->setPresent($item['present'] ?? false);
                    $vt->setComment($item['comment'] ?? '');
                    $em->persist($vt);
                }
            }

            $em->flush();
            return $this->json(['message' => 'Participants mis à jour avec succès']);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
