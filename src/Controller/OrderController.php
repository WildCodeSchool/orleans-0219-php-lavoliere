<?php

namespace App\Controller;

use App\Form\DeliveryType;
use App\Repository\LocationRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/livraison", name="delivery")
     * @param SessionInterface $session
     * @param LocationRepository $locationRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delivery(
        SessionInterface $session,
        LocationRepository $locationRepository,
        ProductRepository $productRepository,
        Request $request
    ) {

        $form = $this->createForm(DeliveryType::class);
        $form->handleRequest($request);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }

        $user = $this->getUser();
        $cart[250] = ['quantity' => 2, 'product' => $productRepository->find(15)];
        $cart[251] = ['quantity' => 1, 'product' => $productRepository->find(16)];
        $cart[252] = ['quantity' => 3, 'product' => $productRepository->find(17)];
        $session->set('cart', $cart);
        $cart = $session->get('cart');
        return $this->render('order/delivery.html.twig', [
            'user' => $user,
            'cart' => $cart,
            'form' => $form->createView(),
            'locations' => $locationRepository->findAll()
        ]);
    }
}
