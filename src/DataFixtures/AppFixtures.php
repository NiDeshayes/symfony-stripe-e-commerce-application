<?php 

// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        $adminUser = new User();
        $adminUser->setUsername('admin');
        $adminUser->setEmail('admin@example.com');
        $adminUser->setDeliveryAddress('123 Admin St, City');
        $adminUser->setPassword(password_hash('adminpassword', PASSWORD_BCRYPT)); // Assurez-vous d'utiliser un mot de passe hashé
        $adminUser->setRoles(['ROLE_ADMIN']); // Rôle administrateur
        
        $manager->persist($adminUser);
        
    
        $products = [
            [
                'name' => 'Blackbelt',
                'description' => 'Black Sweetshirt',
                'price' => 29.90,
                'stripeProductId' => 'prod_QsMx8Q75SZTn8u',
                'stripePriceId' => 'price_1Q0cDyJzTs5MrbsqCxUsLif8',
            ],
            [
                'name' => 'BlueBelt',
                'description' => 'Sweetshirt',
                'price' => 29.90,
                'stripeProductId' => 'prod_QsMyvTSCpk7p7j',
                'stripePriceId' => 'price_1Q0cELJzTs5Mrbsq2QMGacti',
            ],
            [
                'name' => 'Street',
                'description' => 'Sweetshirt',
                'price' => 34.50,
                'stripeProductId' => 'prod_QsMyCMyKBJ9SmO',
                'stripePriceId' => 'price_1Q0cEgJzTs5MrbsqiPO24uGO',
            ],
            [
                'name' => 'Pokeball',
                'description' => 'Sweetshirt',
                'price' => 45.00,
                'stripeProductId' => 'prod_QsMz8l8rTwWY77',
                'stripePriceId' => 'price_1Q0cF3JzTs5Mrbsq9JxaoQmo',
            ],
            [
                'name' => 'PinkLady',
                'description' => 'SweetShirt',
                'price' => 29.90,
                'stripeProductId' => 'prod_QsMzbOIMlxo9dN',
                'stripePriceId' => 'price_1Q0cFRJzTs5Mrbsq346hhtQj',
            ],
            [
                'name' => 'Snow',
                'description' => 'SweetShirt',
                'price' => 32.00,
                'stripeProductId' => 'prod_QsMzJyAAw4yDxg',
                'stripePriceId' => 'price_1Q0cFpJzTs5MrbsqzGGq1um4',
            ],
            [
                'name' => 'Greyback',
                'description' => 'SweetShirt',
                'price' => 28.50,
                'stripeProductId' => 'prod_QsN05frOrh9jpF',
                'stripePriceId' => 'price_1Q0cGAJzTs5MrbsqlPSFdRGN',
            ],
            [
                'name' => 'BlueCloud',
                'description' => 'SweetShirt',
                'price' => 45.00,
                'stripeProductId' => 'prod_QsN0AjsMX2BeoR',
                'stripePriceId' => 'price_1Q0cGXJzTs5MrbsqVpYx81nt',
            ],
            [
                'name' => 'BornInUsa',
                'description' => 'SweetShirt',
                'price' => 59.90,
                'stripeProductId' => 'prod_QsN0RYKypxcS42',
                'stripePriceId' => 'price_1Q0cGrJzTs5Mrbsq6AM1tn4n',
            ],
            [
                'name' => 'GreenSchool',
                'description' => 'SweetShirt',
                'price' => 42.20,
                'stripeProductId' => 'prod_QsN1r4Q7RAqBsi',
                'stripePriceId' => 'price_1Q0cHEJzTs5Mrbsq1JZSwraq',
            ],
        ];

        
        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);
            $product->setActive(true);
            $product->setCreatedAt(new \DateTimeImmutable());
            $product->setUpdatedAt(new \DateTimeImmutable());
            $product->setStripeProductId($data['stripeProductId']);
            $product->setStripePriceId($data['stripePriceId']);
            
            $manager->persist($product);
        }

        $manager->flush();
    }
}
