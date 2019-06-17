<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/livraison", name="order")
     * @param SessionInterface $session
     * @param ProductRepository $productRepository
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }
        $user = $this->getUser();
//        $cart = [];
        /* code pour tester la boucle provenant de session */
        $cart[] = ['quantity' => 2, 'product' => $productRepository->find(1)];
        $cart[] = ['quantity' => 1, 'product' => $productRepository->find(2)];
        $cart[] = ['quantity' => 3, 'product' => $productRepository->find(3)];
        /* à retirer lors de l'ajout de la fonctionnalité d'ajout au panier*/

        $session->set('cart', $cart);
        $cart = $session->get('cart');
        return $this->render('order/delivery.html.twig', [
            'user' => $user,
            'cart' => $cart,
        ]);
    }
}
