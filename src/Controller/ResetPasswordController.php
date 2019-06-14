<?php

namespace App\Controller;

use App\Form\RequestPasswordType;
use App\Repository\UserRepository;
use App\Service\MailerService;
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
        TokenGeneratorInterface $tokenGenerator,
        MailerService $mailer
    ): Response {
        $form = $this->createForm(RequestPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $email = $form->getData()['email'];
            $user = $userRepository->findOneBy(['email' => $email]);

            dump($user);
            if (!$user) {
                $this->addFlash('warning', 'Cet email n\'existe pas');
                return $this->redirectToRoute('reset_password_request');
            }

            $user->setToken($user->getToken());
            $user->setPasswordRequestedAt(new \DateTime());
            $entityManager->flush();

            $bodyMail = $this->renderView(
                'reset_password/reset_password_mail.html.twig',
                ['user' => $user]
            );

            $sender = $this->getParameter('mailer_from');
            $destination = $user->getEmail();

            $mailer->sendMail($sender, $destination, 'Réinitialisation du mot de passe', 'text/html', $bodyMail);
            $this->addFlash(
                'success',
                'Un mail va vous être envoyé afin que vous puissiez renouveller votre mot de passe.
                  Le lien que vous recevrez sera valide 24h.'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
