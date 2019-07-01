<?php

namespace App\Controller;

use App\Service\OrderService;
use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
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
    public function index(CategoryRepository $categoryRepository): Response
    {
        $weekBasketName = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => self::BASKET_CATEGORY]);

        $weekBasket = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findOneBy(['category' => $weekBasketName->getId()]);

        $categories = $categoryRepository->findByAllExceptBasket();

        return $this->render('catalog/index.html.twig', [
            'weekBasket' => $weekBasket,
            'categories' => $categories,
        ]);
    }
    /**
     * @param Product $product
     * @param OrderService $orderService
     * @Route("/ajout-panier-produit/{id}", name="add_cart_product", methods={"POST", "GET"})
     */
    public function add(OrderService $orderService, Product $product)
    {
        $orderService->addToCart($product);
        return $this->redirectToRoute('catalog');
    }
}
