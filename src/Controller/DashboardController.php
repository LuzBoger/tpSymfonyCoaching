<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response
    {
        // Redirection si l'utilisateur est banni
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->render('security/banned.html.twig', [
                'message' => 'Votre compte est banni. Contactez un administrateur pour plus d\'informations.',
            ]);
        }

        // Rendu du tableau de bord
        return $this->render('dashboard/dashboard.html.twig', [
            'isAdmin' => $this->isGranted('ROLE_ADMIN'),
            'isUser' => $this->isGranted('ROLE_USER'),
        ]);
    }
}
