<?php

namespace App\Controller;

use App\Service\OrderService;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    /**
     * @param OrderService $orderService
     * @Route("/panier", name="app_cart")
     */
    public function index(OrderService $orderService)
    {
        $user = $this->getUser();
        $cart = $orderService->getCart();
        $totalCart = $orderService->getTotalCart();
        $totalProduct = $orderService->getTotalProduct();

        return $this->render('cart/index.html.twig', [
            'user' => $user,
            'cart' => $cart,
            'totalProduct' => $totalProduct,
            'totalCart' => $totalCart,
        ]);
    }

    /**
     * @param OrderService $orderService
     * @param Product $product
     * @param Request $request
     * @Route("/{id}", name="cart_delete", methods={"DELETE"})
     */
    public function delete(OrderService $orderService, Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $cart = $orderService->getCart();
            unset($cart[$product->getId()]);
            $orderService->setCart($cart);
        }
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @param OrderService $orderService
     * @param Product $product
     * @Route("/panier/{id}/augmenter", name="cart_increment", methods={"GET","POST"})
     */
    public function increaseQuantity(Product $product, OrderService $orderService)
    {
        $cart = $orderService->getCart();
        $cartProduct = $cart[$product->getId()];
        $cartProduct->increment($cartProduct);
        $orderService->setCart($cart);
        $quantity = $cartProduct->getQuantity();
        $id = $product->getId();
        $totalCart = $orderService->getTotalCart();
        $totalProduct = $cartProduct->getTotal();
        $cartCount = $orderService->getTotalProduct();
        return $this->json([
            'quantity' => $quantity,
            'id' => $id,
            'totalProduct' => $totalProduct,
            'totalCart' => $totalCart,
            'cartCount' => $cartCount,
        ]);
    }

    /**
     * @param OrderService $orderService
     * @param Product $product
     * @Route("/panier/{id}/diminuer", name="cart_decrement",methods={"GET","POST"})
     */
    public function decreaseQuantity(Product $product, OrderService $orderService)
    {
        $cart = $orderService->getCart();
        $cartProduct = $cart[$product->getId()];
        $cartProduct->decrement($cartProduct);
        $orderService->setCart($cart);
        $quantity = $cartProduct->getQuantity();
        $id = $product->getId();
        $totalCart = $orderService->getTotalCart();
        $totalProduct = $cartProduct->getTotal();
        $cartCount = $orderService->getTotalProduct();
        return $this->json([
            'quantity' => $quantity,
            'id' => $id,
            'totalProduct' => $totalProduct,
            'totalCart' => $totalCart,
            'cartCount' => $cartCount,
        ]);
    }
}
