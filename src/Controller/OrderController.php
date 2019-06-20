<?php

namespace App\Controller;

use App\Form\DeliveryType;
use App\Repository\LocationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Location;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/livraison", name="delivery", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param SessionInterface $session
     * @param LocationRepository $locationRepository
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delivery(SessionInterface $session, LocationRepository $locationRepository, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(DeliveryType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        if (!$session->has('cart')) {
            return $this->redirectToRoute('app_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $session->set('delivery', $data['name']);
            $session->set('deliveryDate', $data['deliveryDate']);
            $session->set('comments', $data['comments']);
            return $this->redirectToRoute('validation');
        }

        $cart = $session->get('cart');
        return $this->render('order/delivery.html.twig', [
            'user' => $user,
            'cart' => $cart,
            'form' => $form->createView(),
            'locations' => $locationRepository->findAll()
        ]);
    }

    /**
     * @Route("/validation", name="validation", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function validation()
    {
    }

}
