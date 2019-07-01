<?php

namespace App\Controller\Admin;

use App\Entity\Purchase;
use App\Form\PurchaseType;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     */
    public function index(PurchaseRepository $purchaseRepository): Response
    {
        return $this->render('purchase/index.html.twig', [
            'purchases' => $purchaseRepository->findAllByDescDate(),
        ]);
    }

    /**
     * @Route("/new", name="purchase_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $purchase = new Purchase();
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($purchase);
            $entityManager->flush();

            return $this->redirectToRoute('purchase_index');
        }

        return $this->render('purchase/new.html.twig', [
            'purchase' => $purchase,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="purchase_show", methods={"GET"})
     */
    public function show(Purchase $purchase): Response
    {
        return $this->render('purchase/show.html.twig', [
            'purchase' => $purchase,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="purchase_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Purchase $purchase): Response
    {
        $form = $this->createForm(PurchaseType::class, $purchase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('purchase_index', [
                'id' => $purchase->getId(),
            ]);
        }

        return $this->render('purchase/edit.html.twig', [
            'purchase' => $purchase,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="purchase_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Purchase $purchase): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchase->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($purchase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('purchase_index');
    }
}
