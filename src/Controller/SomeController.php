<?php

// src/Controller/SomeController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SomeController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        // Vérifie si un utilisateur est connecté
        if ($this->getUser()) {
            // L'utilisateur est connecté, afficher la page de profil
            return $this->render('profile.html.twig');
        } else {
            // L'utilisateur n'est pas connecté, rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
    }
}
