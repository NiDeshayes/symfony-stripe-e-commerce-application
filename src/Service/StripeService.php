<?php

namespace App\Service;

use App\Entity\Product;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Price;


class StripeService
{
    private StripeClient $stripe;

    public function createproduct(product $product): \stripe\product
    {
        return $this->getStripe()->products->create([
            'name' => $product->getname(),
            'description' => $product->getDescription(),
            'active' => $product->isActive()

        ]);
    }

    public function createPrice(product $product): Price
    {

        return $this->getStripe()->prices->create([

            'unit_amount' => $product->getPrice(),
            'currency' => 'EUR' ,
            'product' => $product->getStripeProductId()

        ]);


    }


    public function updateProduct(product $product): \Stripe\Product
    {
        return $this->getStripe()->products->update([
            'name' => $product->getname(),
            'description' => $product->getDescription(),
            'active' => $product->isActive()
        ]);
         
    }
    private function getStripe(): StripeClient
    {
        return $this->stripe ??= new StripeClient(
            $_ENV['STRIPE_API_SECRET']
        );

    }

}
    




