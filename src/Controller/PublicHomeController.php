<?php 

// src/Controller/PublicHomeController.php
namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicHomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_public_home')]
    public function index(): Response
    {
        // Récupérer les trois produits mis en avant
        $featuredProducts = $this->entityManager->getRepository(Product::class)
            ->findBy([], null, 3);

        return $this->render('public_home/index.html.twig', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
