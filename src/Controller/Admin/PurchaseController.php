<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
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
}
