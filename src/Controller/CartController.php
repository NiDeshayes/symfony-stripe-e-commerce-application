<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CartController extends AbstractController
{
    private $entityManager;
    private $stripeService;
    private $urlGenerator;

    public function __construct(EntityManagerInterface $entityManager, StripeService $stripeService, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->stripeService = $stripeService;
        $this->urlGenerator = $urlGenerator;
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
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
                $total += $product->getPrice() * $quantity;
            }
        }

        return $this->render('cart/index.html.twig', [
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id, SessionInterface $session): Response
    {
        $cart = $session->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $session->set('cart', $cart);
        }

        return $this->redirectToRoute('cart');
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(SessionInterface $session): Response
    {
        // Préparer les articles du panier pour Stripe
        $cart = $session->get('cart', []);
        $productRepository = $this->entityManager->getRepository(Product::class);
        $lineItems = [];

        foreach ($cart as $id => $quantity) {
            $product = $productRepository->find($id);
            if ($product) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->getName(),
                        ],
                        'unit_amount' => $product->getPrice()* 100, // Assurez-vous que getPrice retourne déjà en centimes
                    ],
                    'quantity' => $quantity,
                ];
            }
        }

        // Créer une session de paiement Stripe
        $session = $this->stripeService->createCheckoutSession(
            $lineItems,
            $this->urlGenerator->generate('checkout_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            $this->urlGenerator->generate('checkout_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL)
        );

        // Rediriger vers l'URL de paiement Stripe
        return $this->redirect($session->url);
    }
}
