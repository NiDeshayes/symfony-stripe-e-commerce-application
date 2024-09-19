<?php

// src/Controller/HomeController.php
namespace App\Controller;

    use App\Entity\Product;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class HomeController extends AbstractController
    {
        private EntityManagerInterface $entityManager;

        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->entityManager = $entityManager;
        }

        #[Route('/home', name: 'app_home_index')]
        public function index(): Response
        {
            // Récupérer les trois produits mis en avant
            $featuredProducts = $this->entityManager->getRepository(Product::class)
                ->findBy([], null, 3);

            return $this->render('home/index.html.twig', [
                'featuredProducts' => $featuredProducts,
            ]);
        }
    }
