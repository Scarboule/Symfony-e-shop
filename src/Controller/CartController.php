<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(CartService $cartService): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->getCartItems(),
            'total' => $cartService->getTotal(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(Product $product, CartService $cartService): Response
    {
        $cartService->addItem($product);

        $this->addFlash('success', sprintf('Le produit %s a été ajouté au panier.', $product->getName()));

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(Product $product, CartService $cartService): Response
    {
        $cartService->removeItem($product);

        $this->addFlash('success', sprintf('Le produit %s a été retiré du panier.', $product->getName()));

        return $this->redirectToRoute('cart_index');
    }
}

