<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use App\Repository\PurchaseRepository;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/commande")
 */
class PurchaseController extends AbstractController
{
    /**
     * @Route("/", name="purchase_index", methods={"GET"})
     * @param PurchaseRepository $purchaseRepository
     * @param OrderService $orderService
     * @return Response
     */
    public function index(PurchaseRepository $purchaseRepository, OrderService $orderService): Response
    {
        $form = $this->createFormBuilder()
            ->add('startDate', DateType::class, [
                'label' => 'Entre le : ',
                'label_attr' => ['class' => 'col-md-12'],
                'model_timezone' => 'Europe/Paris',
                'widget' => 'single_text',

            ])
            ->add('endDate', DateType::class, [
                'label' => 'Et le :',
                'label_attr' => ['class' => 'col-md-12'],
                'model_timezone' => 'Europe/Paris',
                'widget' => 'single_text',
            ])
            ->getForm();

        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchaseRepository->findAllByDescDate(),
            'total' => $orderService,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/{id}", name="purchase_show", methods={"GET"})
     */
    public function show(Purchase $purchase, OrderService $orderService): Response
    {
        return $this->render('purchase/show.html.twig', [
            'purchase' => $purchase,
            'total' => $orderService
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

        return $this->redirectToRoute('purchase_index');
    }
}
