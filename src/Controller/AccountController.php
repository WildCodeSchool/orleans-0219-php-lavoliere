<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserInformationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @package App\Controller
 * @Route("/mon-compte")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/accueil", name="app_account")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edition", name="account_edit", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserInformationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vos informations ont bien été modifiés');
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit_account.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
