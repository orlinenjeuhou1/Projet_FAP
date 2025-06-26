<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    #[Route('/api/reset-password', name: 'reset_password', methods: ['POST'])]
    public function __invoke(Request $request, UserRepository $userRepo, UserPasswordHasherInterface $hasher)
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $newPassword = $data['newPassword'] ?? null;

        if (!$email || !$newPassword) {
            return $this->json(['error' => 'Email et nouveau mot de passe requis'], 400);
        }

        $user = $userRepo->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $user->setPassword($hasher->hashPassword($user, $newPassword));
        $userRepo->getEntityManager()->flush();

        return $this->json(['message' => 'Mot de passe réinitialisé avec succès']);
    }
}