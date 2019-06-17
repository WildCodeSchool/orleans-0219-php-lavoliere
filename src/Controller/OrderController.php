<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/livraison", name="delivery")
     * @param SessionInterface $session
     * @param ProductRepository $productRepository
     */
    public function delivery(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }
        $user = $this->getUser();
        $cart = [];

        $session->set('cart', $cart);
        $cart = $session->get('cart');
        return $this->render('order/delivery.html.twig', [
            'user' => $user,
            'cart' => $cart,
        ]);
    }
}
