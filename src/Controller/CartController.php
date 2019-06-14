<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
        $cart = [];
        $session->set('cart', $cart);
        $cart = $session->get('cart');
        return $this->render('cart/index.html.twig', [
            'user' => $user,
            'cart' => $cart,
        ]);
    }
}
