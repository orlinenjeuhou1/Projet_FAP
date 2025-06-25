<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestSentryController extends AbstractController
{
    #[Route('/sentry-test', name: 'sentry_test')]
    public function index(): JsonResponse
    {
        throw new \Exception('Erreur volontaire pour test Sentry 🎯');
    }
}
