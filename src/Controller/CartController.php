<?php

namespace App\Controller;

use App\Service\OrderService;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    /**
     * @param SessionInterface $session
     * @Route("/panier", name="app_cart")
     */
    public function index(SessionInterface $session, OrderService $orderService)
    {
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }
        $user = $this->getUser();
        $cart = $session->get('cart');
        $orderService->calculateTotalByProduct();
        $totalCart = $orderService->calculateTotalCart();
        $totalProduct = $orderService->calculateTotalProduct();
        return $this->render('cart/index.html.twig', [
            'user' => $user,
            'cart' => $cart,
            'totalProduct' => $totalProduct,
            'totalCart' => $totalCart,
        ]);
    }

    /**
     * @param SessionInterface $session
     * @param Product $product
     * @param Request $request
     * @Route("/{id}", name="cart_delete", methods={"DELETE"})
     */
    public function delete(SessionInterface $session, Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $cart = $session->get('cart');
            unset($cart[$product->getId()]);
            $session->set('cart', $cart);
        }
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @param OrderService $orderService
     * @param SessionInterface $session
     * @Route("/panier/{id}/increase", name="cart_increment", methods={"GET","POST"})
     */
    public function increaseQuantity(Product $product, OrderService $orderService, SessionInterface $session)
    {
        $cart = $session->get('cart');
        $cartProduct = $cart[$product->getId()];
        $orderService->increaseCart($cartProduct);
        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * @param OrderService $orderService
     * @param SessionInterface $session
     * @Route("/panier/{id}/decrease", name="cart_decrement",methods={"GET","POST"})
     */
    public function decreaseQuantity(Product $product, OrderService $orderService, SessionInterface $session)
    {
        $cart = $session->get('cart');
        $cartProduct = $cart[$product->getId()];
        $orderService->decreaseCart($cartProduct);
        $session->set('cart', $cart);
        return $this->redirectToRoute('app_cart');
    }
}
