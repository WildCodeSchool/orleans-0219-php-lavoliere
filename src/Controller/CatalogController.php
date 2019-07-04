<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Service\OrderService;
use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
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

        $recipe = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findOneBy(['isPresent' => true]);

        $weekBasket = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findOneBy(['category' => $weekBasketName->getId()]);
      
        $weekBasket = [];

        if (isset($weekBasketName)) {
            $weekBasket = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findOneBy(['category' => $weekBasketName->getId()]);
        }
        $categories = $categoryRepository->findByAllExceptBasket();

        return $this->render('catalog/index.html.twig', [
            'weekBasket' => $weekBasket,
            'recipe' => $recipe,
            'categories' => $categories,
        ]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @param OrderService $orderService
     * @Route("/ajout-panier-produit/{id}", name="add_cart_product", methods={"POST", "GET"})
     */
    public function add(?Request $request, OrderService $orderService, Product $product)
    {
        if ($request->request->get('quantity')) {
            $quantity = $request->request->get('quantity');
        } else {
            $quantity = 1;
        }
        $orderService->addToCart($product, $quantity);

        $weekBasketName = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => self::BASKET_CATEGORY]);

        $anchor = 'card-product-' . $product->getId();

        if ($product->getCategory() == $weekBasketName) {
            $anchor = '';
        }

        return $this->redirectToRoute('catalog', ['_fragment' => $anchor]);
    }
}
