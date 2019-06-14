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

        /* code pour tester la boucle provenant de session */
        $cart[] = ['quantity' => 2, 'product' => $productRepository->find(250)];
        $cart[] = ['quantity' => 1, 'product' => $productRepository->find(251)];
        $cart[] = ['quantity' => 3, 'product' => $productRepository->find(252)];
        /* à retirer lors de l'ajout de la fonctionnalité d'ajout au panier*/

        $session->set('cart', $cart);
        $cart = $session->get('cart');
        return $this->render('cart/index.html.twig', [
            'user' => $user,
            'cart' => $cart,
        ]);
    }
}
