<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use App\Entity\User;
use App\Repository\PurchaseProductRepository;
use App\Repository\PurchaseRepository;
use App\Service\DailyMailerService;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/commande")
 */
class PurchaseController extends AbstractController
{
    /**
     * @Route("/", name="purchase_index", methods={"GET","POST"})
     * @param Request $request
     * @param PurchaseRepository $purchaseRepository
     * @param OrderService $orderService
     * @return Response
     * @throws \Exception
     */
    public function index(
        Request $request,
        PurchaseRepository $purchaseRepository,
        OrderService $orderService
    ): Response {

        $startDate = new \DateTime();
        $startDate->setTime(0, 0);
        $endDate = new \DateTime('+7 day');

        $form = $this->createFormBuilder()
            ->add('startDate', DateType::class, [
                'label' => 'Entre le : ',
                'label_attr' => ['class' => 'col-md-12'],
                'model_timezone' => 'Europe/Paris',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('endDate', DateType::class, [
                'label' => 'Et le :',
                'label_attr' => ['class' => 'col-md-12'],
                'model_timezone' => 'Europe/Paris',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $startDate = $form->getData()['startDate'];
            $endDate = $form->getData()['endDate'];
        }
        $purchases = $purchaseRepository->findPurchasesByDateInterval($startDate, $endDate);

        $startDateFormated = $startDate->format('Y-m-d');
        $endDateFormated = $endDate->format('Y-m-d');

        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchases,
            'form' => $form->createView(),
            'orderService' => $orderService,
            'startDate' => $startDateFormated,
            'endDate' => $endDateFormated
        ]);
    }

    /**
     * @Route("/{id}", name="purchase_show", methods={"GET"})
     */
    public function show(Purchase $purchase, OrderService $orderService): Response
    {
        return $this->render('purchase/show.html.twig', [
            'purchase' => $purchase,
            'orderService' => $orderService
        ]);
    }

    /**
     * @Route("/{id}", name="purchase_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Purchase $purchase): Response
    {
        if ($this->isCsrfTokenValid('delete' . $purchase->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($purchase);
            $entityManager->flush();
        }

        $this->addFlash('admin-success', 'Votre suppression a bien été effectuée');

        return $this->redirectToRoute('purchase_index');
    }

    /**
     * @Route("/client/{id}", name="purchase_user", methods={"GET"})
     * @param User $user
     * @param PurchaseRepository $purchaseRepository
     * @param OrderService $orderService
     * @return Response
     */
    public function showPurchasesByUser(
        User $user,
        PurchaseRepository $purchaseRepository,
        OrderService $orderService
    ): Response {

        $purchases = $user->getPurchases();

        return $this->render('purchase/showByUser.html.twig', [
            'user' => $user,
            'purchases' => $purchases,
            'orderService' => $orderService
        ]);
    }

    /**
     * @Route("/{startDate}/{endDate}/pdf", name = "pdf_dateInterval_purchase")
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param DailyMailerService $dailyMailerService
     * @param PurchaseRepository $purchaseRepository
     * @param PurchaseProductRepository $purchaseProductRepository
     * @param OrderService $orderService
     */
    public function pdfGeneratorByDateInterval(
        \DateTime $startDate,
        \DateTime $endDate,
        DailyMailerService $dailyMailerService,
        PurchaseRepository $purchaseRepository,
        PurchaseProductRepository $purchaseProductRepository,
        OrderService $orderService
    ) {
        return $dailyMailerService->pdfPurchaseGeneratorByDateInterval(
            $purchaseRepository,
            $purchaseProductRepository,
            $orderService,
            $startDate,
            $endDate
        );
    }

    /**
     * @Route("/{id}/pdf", name = "pdf_purchase")
     * @param DailyMailerService $dailyMailerService
     * @param Purchase $purchase
     * @param OrderService $orderService
     */
    public function pdfGenerator(
        DailyMailerService $dailyMailerService,
        Purchase $purchase,
        OrderService $orderService
    ) {
        return $dailyMailerService->pdfPurchaseGenerator($purchase, $orderService);
    }
}
