<?php

// src/Controller/CheckoutController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckoutController extends AbstractController
{
    #[Route('/checkout/success', name: 'checkout_success')]
    public function success(): Response
    {
        // Logique pour la page de succès (e.g., afficher un message de confirmation)
        return $this->render('checkout/success.html.twig');
    }

    #[Route('/checkout/cancel', name: 'checkout_cancel')]
    public function cancel(): Response
    {
        // Logique pour la page d'annulation (e.g., afficher un message d'erreur)
        return $this->render('checkout/cancel.html.twig');
    }
}
