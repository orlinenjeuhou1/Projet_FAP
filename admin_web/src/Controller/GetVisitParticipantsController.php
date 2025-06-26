<?php

namespace App\Controller;

use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetVisitParticipantsController extends AbstractController
{
    public function __invoke(Request $request, VisitRepository $visitRepo): JsonResponse
    {
        $id = $request->attributes->get('id');
        $visit = $visitRepo->find($id);

        if (!$visit) {
            return $this->json(['error' => 'Visite introuvable'], 404);
        }

        $data = [];
        foreach ($visit->getVisitTourists() as $vt) {
            $tourist = $vt->getTourist();
            $data[] = [
                'id' => $vt->getId(),
                'firstname' => $tourist->getFirstname(),
                'lastname' => $tourist->getLastname(),
                'present' => $vt->isPresent(),
                'comment' => $vt->getComment(),
            ];
        }

        return $this->json($data);
    }
}
