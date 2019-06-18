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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }

        $user = $this->getUser();
        if (empty($session)) {
            $cart[250] = ['quantity' => 2, 'product' => $productRepository->find(250)];
            $cart[251] = ['quantity' => 1, 'product' => $productRepository->find(251)];
            $cart[252] = ['quantity' => 3, 'product' => $productRepository->find(252)];
            $cart[253] = ['quantity' => 4, 'product' => $productRepository->find(253)];
            $cart[254] = ['quantity' => 5, 'product' => $productRepository->find(254)];
            $cart[255] = ['quantity' => 2, 'product' => $productRepository->find(255)];
            $session->set('cart', $cart);
        }

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
