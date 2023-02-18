<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Repository\ProductCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CategoryController extends AbstractController
{
    /*#[Route('/category', name: 'app_category')]
    public function index(): Response
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}*/
    #[Route('/category/{id}', name: 'category_show')]
    public function show($id, ProductCategoryRepository $productCategoryRepository, ProductCategory $productCategory): Response
    {
        $products = $productCategory->getProducts();
        $category = $productCategoryRepository->find($id);


        if (!$category) {
            throw $this->createNotFoundException('Category of product not found');
        }

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'products' => $products,
            'controller_name' => 'CategoryController'
        ]);
    }

    #[Route('/category/{id}/{sort}', name: 'category_show_sorted')]
    public function showSorted($id, $sort, ProductCategoryRepository $productCategoryRepository, ProductCategory $productCategory): Response
    {
        $products = $productCategory->getProducts()->toArray();
        $category = $productCategoryRepository->find($id);

        if ($sort == 'asc') {
            usort($products, function($a, $b) {
                return $a->getPrice() - $b->getPrice();
            });
        } elseif ($sort == 'desc') {
            usort($products, function($a, $b) {
                return $b->getPrice() - $a->getPrice();
            });
        }
        return $this->render('category/index.html.twig', [
            'category' => $category,
            'products' => $products,
            'controller_name' => 'CategoryController'
        ]);
    }

}
