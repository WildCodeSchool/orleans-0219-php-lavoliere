<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;

class CartController extends AbstractController
{
    /**
     * @param SessionInterface $session
     * @param ProductRepository $productRepository
     * @Route("/panier", name="app_cart")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }
        $user = $this->getUser();
        $cart = $session->get('cart');
        return $this->render('cart/index.html.twig', [
            'user' => $user,
            'cart' => $cart,
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
}
