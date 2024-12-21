<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'user_profile')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function profile(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
