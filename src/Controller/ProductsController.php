<?php 

// src/Controller/ProductsController.php
namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/products', name: 'products')]
    public function index(Request $request): Response
    {
        $priceRange = $request->query->get('price_range');
        $productRepository = $this->entityManager->getRepository(Product::class);

        $queryBuilder = $productRepository->createQueryBuilder('p');

        if ($priceRange) {
            [$minPrice, $maxPrice] = explode('-', $priceRange);
            $queryBuilder
                ->andWhere('p.price >= :minPrice')
                ->andWhere('p.price <= :maxPrice')
                ->setParameter('minPrice', $minPrice )
                ->setParameter('maxPrice', $maxPrice );
        }

        $products = $queryBuilder->getQuery()->getResult();

        return $this->render('products/index.html.twig', [
            'products' => $products,
            'selectedPriceRange' => $priceRange,
        ]);
    }

    #[Route('/product/{id}', name: 'product_detail')]
    public function detail(int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas.');
        }

        return $this->render('products/detail.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function addToCart(int $id, SessionInterface $session): RedirectResponse
    {
        $cart = $session->get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart');
    }
}
