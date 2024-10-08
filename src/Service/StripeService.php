<?php

namespace App\Service;

use App\Entity\Product;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Price;
use Stripe\StripeClient;

class StripeService
{
    private StripeClient $stripe;

    public function __construct(string $stripeApiSecret)
    {
        $this->stripe = new StripeClient($stripeApiSecret);
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
            'unit_amount' => $product->getPrice() * 100,  // Multiplier le prix par 100
            'currency' => 'eur',
            'product' => $product->getStripeProductId(),
        ]);
    }

    public function updateProduct(Product $product): \Stripe\Product
    {
        return $this->stripe->products->update($product->getStripeProductId(), [
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'active' => $product->isActive(),
        ]);
    }

    public function createCheckoutSession(array $lineItems, string $successUrl, string $cancelUrl): CheckoutSession
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ]);
    }
}
