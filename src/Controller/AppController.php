<?php

namespace App\Controller;

use App\Repository\ProductCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AppController extends AbstractController
{
    /*#[Route('/app', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
}*/
    #[Route('/', name: 'app_index')]
    public function index(ProductCategoryRepository $productCategoryRepository): Response
    {
        return $this->render('app/index.html.twig', [
        'productCategory' => $productCategoryRepository->findAll(),
        'controller_name' => 'AppController',
        ]);
    }
}
