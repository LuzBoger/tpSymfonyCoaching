<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Vérifiez si l'utilisateur est connecté, pour éviter les conflits
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home'); // Redirigez si déjà connecté
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {

    }

    #[Route(path: '/banned', name: 'banned_page')]
    public function banned(): Response
    {
        return $this->render('security/banned.html.twig', [
            'message' => 'Votre compte a été temporairement restreint. Contactez un administrateur pour plus d\'informations.',
        ]);
    }
}
