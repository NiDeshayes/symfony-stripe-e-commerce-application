<?php

// src/Controller/CartController.php
namespace App\Controller;

use App\Entity\Product;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private StripeService $stripeService;

    public function __construct(EntityManagerInterface $entityManager, StripeService $stripeService)
    {
        $this->entityManager = $entityManager;
        $this->stripeService = $stripeService;
    }

    #[Route('/cart', name: 'cart')]
    public function index(SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        
        // Récupérer les produits
        $productRepository = $this->entityManager->getRepository(Product::class);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            if ($product) {
                $priceInEuros = $product->getPrice() / 100; // Conversion en euros
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'priceInEuros' => $priceInEuros
                ];
                $total += $priceInEuros * $quantity;
            }
        }

        return $this->render('cart/index.html.twig', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'remove_from_cart')]
    public function removeFromCart(int $id, SessionInterface $session): RedirectResponse
    {
        $cart = $session->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]); // Remove item from cart
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(SessionInterface $session): RedirectResponse
    {
        $cart = $session->get('cart', []);
        
        $lineItems = [];

        // Créez une session Stripe Checkout
        foreach ($cart as $id => $quantity) {
            $product = $this->entityManager->getRepository(Product::class)->find($id);
            if ($product) {
                $priceInCents = $product->getPrice();
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->getName(),
                        ],
                        'unit_amount' => $priceInCents,
                    ],
                    'quantity' => $quantity,
                ];
            }
        }

        $session = $this->stripeService->createCheckoutSession($lineItems);

        return $this->redirect($session->url, 303);
    }
}
