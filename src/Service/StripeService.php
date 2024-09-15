<?php

namespace App\Service;

use App\Entity\Product;
use Stripe\StripeClient;
use Stripe\Price;
use Stripe\Checkout\Session;

class StripeService
{
    private StripeClient $stripe;

    public function __construct(string $stripeSecretKey)
    {
        $this->stripe = new StripeClient($stripeSecretKey);
    }

    public function createProduct(Product $product): \Stripe\Product
    {
        return $this->stripe->products->create([
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'active' => $product->isActive(),
        ]);
    }

    public function createPrice(Product $product): Price
    {
        return $this->stripe->prices->create([
            'unit_amount' => $product->getPrice() * 100, // Convert to cents
            'currency' => 'eur',
            'product' => $product->getStripeProductId(),
        ]);
    }

    public function updateProduct(Product $product): \Stripe\Product
    {
        return $this->stripe->products->update(
            $product->getStripeProductId(),
            [
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'active' => $product->isActive(),
            ]
        );
    }

    public function createCheckoutSession(array $lineItems): Session
    {
        $successUrl = $_ENV['STRIPE_SUCCESS_URL'] ?? null;
        $cancelUrl = $_ENV['STRIPE_CANCEL_URL'] ?? null;

        if (!$successUrl || !$cancelUrl) {
            throw new \RuntimeException('Les variables d\'environnement STRIPE_SUCCESS_URL ou STRIPE_CANCEL_URL ne sont pas définies.');
        }

        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
           
        ]);
    }
}

