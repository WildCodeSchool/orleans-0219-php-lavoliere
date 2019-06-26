<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\Purchase;
use App\Form\DeliveryType;
use App\Repository\LocationRepository;
use App\Service\LocationService;
use App\Service\MailerService;
use App\Service\OrderService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @param OrderService $orderService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delivery(
        SessionInterface $session,
        LocationRepository $locationRepository,
        Request $request,
        OrderService $orderService
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(DeliveryType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        if (empty($session->get('cart'))) {
            return $this->redirectToRoute('app_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $delivery = new Delivery();
            $data = $form->getData();
            $delivery->setLocation($data[DeliveryType::NAME_FIELD]);
            $delivery->setDeliveryDate($data[DeliveryType::DELIVERY_DATE_FIELD]);
            $delivery->setComments($data[DeliveryType::COMMENT_FIELD]);
            $orderService->setDelivery($delivery);
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
     * @param SessionInterface $session
     * @param OrderService $orderService
     * @param LocationService $locationService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validation(
        SessionInterface $session,
        OrderService $orderService,
        LocationService $locationService
    ) {

        if (empty($session->get('cart'))) {
            return $this->redirectToRoute('app_index');
        }

        if (empty($session->get('delivery'))) {
            return $this->redirectToRoute('delivery');
        }

        $orderService->calculateTotalByProduct();
        $totalCart = $orderService->calculateTotalCart();
        $totalProduct = $orderService->calculateTotalProduct();
        $user = $this->getUser();
        $cart = $session->get('cart');
        $delivery = $orderService->getDelivery();
        $location = $delivery->getLocation();
        $adress = $locationService->formatLocation($location);

        return $this->render('order/validation.html.twig', [
            'user' => $user,
            'cart' => $cart,
            'delivery' => $delivery,
            'adress' => $adress,
            'totalCart' => $totalCart,
            'totalProduct' => $totalProduct
        ]);
    }

    /**
     * @Route("/confirmation", name="confirm_order", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     * @param SessionInterface $session
     * @param OrderService $orderService
     * @param LocationService $locationService
     * @param MailerService $mailer
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function sendOrder(
        SessionInterface $session,
        OrderService $orderService,
        LocationService $locationService,
        MailerService $mailer
    ) {
        if (empty($session->get('cart'))) {
            return $this->redirectToRoute('app_index');
        }

        if (empty($session->get('delivery'))) {
            return $this->redirectToRoute('delivery');
        }

        $dateTime = new \DateTime();
        $delivery = $orderService->getDelivery();
        $cartProducts = $orderService->getCart();

        $purchase = new Purchase();
        $purchase->setUser($this->getUser());
        $purchase->setLocation($locationService->formatLocation($delivery->getLocation()));
        $purchase->setDeliveryDate($delivery->getDeliveryDate());
        $purchase->setComment($delivery->getComments());
        $purchase->setOrderDate($dateTime);

        foreach ($cartProducts as $cartProduct) {
            $purchaseProduct = $cartProduct->toPurchaseProduct();
            $purchase->addPurchaseProduct($purchaseProduct);
        }
        $orderService->calculateTotalPurchase($purchase);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($purchase);
        $entityManager->flush();

        $user = $this->getUser();
        $sender = $this->getParameter('mailer_from');
        $destination = $user->getEmail();
        $bodyMail = $this->renderView(
            'emails/UserPurchaseMail.html.twig',
            [
                'user' => $user,
                'purchase' => $purchase,
                'total' => $orderService->calculateTotalPurchase($purchase)
            ]
        );
        $mailer->sendMail($sender, $destination, 'Votre commande a bien été enregistrée', 'text/html', $bodyMail);

        session_reset();
        return $this->redirectToRoute('success_order');
    }

    /**
     * @Route("/commande-reussie", name="success_order", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function successOrder(SessionInterface $session)
    {
        $session->clear();
        return $this->render('order/success.html.twig');
    }


    /**
     * @param OrderService $orderService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function counterProduct(OrderService $orderService)
    {
        $quantity = $orderService->calculateTotalProduct();
        return $this->render('_navbar_cart_counter.html.twig', [
            'quantity' => $quantity
        ]);
    }
}
