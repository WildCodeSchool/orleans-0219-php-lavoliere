<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RequestPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    /**
     * @Route("/request/password", name="reset__password_request")
     */
    public function request(Request $request, User $user): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(RequestPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }

        return $this->render('reset_password/index.html.twig', [
            'controller_name' => 'ResetPasswordController',
        ]);
    }
}
