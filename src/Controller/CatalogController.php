<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    const BASKET_CATEGORY = 'Panier de la semaine';

    /**
     * @Route("/catalogue", name="catalog")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $weekBasketName = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => self::BASKET_CATEGORY]);

        $weekBasket = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findOneBy(['category' => $weekBasketName->getId()]);

        return $this->render('catalog/index.html.twig', [
            'weekBasket' => $weekBasket,
            'products' => $productRepository->findAll(),
        ]);
    }
}
