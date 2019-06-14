<?php

namespace App\Controller;

use App\Form\RequestPasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ResetPasswordController extends AbstractController
{
    /**
     * @Route("/request/password", name="reset_password_request")
     */
    public function request(
        Request $request,
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator
    ): Response {
        $form = $this->createForm(RequestPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $email = $form->getData()['email'];
            $user = $userRepository->findOneByEmail($email);

            if (!$user) {
                $this->addFlash('danger', 'Cet email n\'existe pas');
                $this->redirectToRoute('reset_password_request');
            }

            $user->setToken($tokenGenerator->generateToken());
            $user->setPasswordRequestedAt(new \DateTime());
            $entityManager->flush();
        }

        return $this->render('reset_password/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
