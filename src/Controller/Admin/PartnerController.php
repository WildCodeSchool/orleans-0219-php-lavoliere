<?php

namespace App\Controller\Admin;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partners")
 */
class PartnerController extends AbstractController
{
    /**
     * @Route("/", name="partners_index", methods={"GET"})
     */
    public function index(PartnerRepository $partnersRepository): Response
    {
        return $this->render('partners/index.html.twig', [
            'partners' => $partnersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="partners_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('partners_index');
        }

        return $this->render('partners/new.html.twig', [
            'partner' => $partner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partners_show", methods={"GET"})
     */
    public function show(Partner $partner): Response
    {
        return $this->render('partners/show.html.twig', [
            'partner' => $partner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partners_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partner $partner): Response
    {
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partners_index', [
                'id' => $partner->getId(),
            ]);
        }

        return $this->render('partners/edit.html.twig', [
            'partner' => $partner,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partners_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partner $partner): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partners_index');
    }
}
