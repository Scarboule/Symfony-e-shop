<?php

namespace App\Controller;

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
    public function show($id, ProductCategoryRepository $productCategoryRepository): Response
    {
        $category = $productCategoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Category of product not found');
        }

        return $this->render('category/index.html.twig', [
            'category' => $category,
            'controller_name' => 'CategoryController'
        ]);
    }
}
