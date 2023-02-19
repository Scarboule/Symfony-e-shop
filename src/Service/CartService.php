<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function addItem(Product $product)
    {
        $cart = $this->session->get('cart', []);

        $id = $product->getId();
        if (!isset($cart[$id])) {
            $cart[$id] = [
                'quantity' => 0,
                'product' => $product
            ];
        }

        $cart[$id]['quantity']++;

        $this->session->set('cart', $cart);
    }

    public function removeItem(Product $product)
    {
        $cart = $this->session->get('cart', []);

        $id = $product->getId();
        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            } else {
                unset($cart[$id]);
            }

            $this->session->set('cart', $cart);
        }
    }

    public function getCartItems(): array
    {
        return $this->session->get('cart', []);
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getCartItems() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }
}

