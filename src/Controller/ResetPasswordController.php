<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RequestPasswordType;
use App\Form\ResettingPasswordType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ResetPasswordController extends AbstractController
{
    const PASSWORD_EXPIRATION = 24;

    /**
     * @Route("/demande/mot-de-passe", name="reset_password_request")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param TokenGeneratorInterface $tokenGenerator
     * @param MailerService $mailer
     * @return Response
     * @throws \Exception
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

            if (!$user) {
                $this->addFlash('warning', 'Cet email n\'existe pas');
                return $this->redirectToRoute('reset_password_request');
            }

            $user->setResetPasswordToken($tokenGenerator->generateToken());
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
                  Le lien que vous recevrez sera valide ' . self::PASSWORD_EXPIRATION . 'h.'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/request_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{token}", name="reset_password")
     * @param User $user
     * @param string $resetPasswordToken
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     * @throws \Exception
     */
    public function reset(
        User $user,
        string $resetPasswordToken,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        if ($user->getResetPasswordToken() === null ||
            $resetPasswordToken !== $user->getResetPasswordToken() ||
            !$this->isRequestInTime($user->getPasswordRequestedAt())) {
            $this->addFlash('warning', 'Le lien de réinitialisation a expiré');
            return $this->redirectToRoute('app_index');
        }

        $form = $this->createForm(ResettingPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($password);
            $user->setResetPasswordToken(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe à bien été changé.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/change_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param \DateTime|null $passwordRequestedAt
     * @return bool
     * @throws \Exception
     */
    private function isRequestInTime(\DateTime $passwordRequestedAt = null)
    {
        $response = true;

        if ($passwordRequestedAt === null) {
            $response = false;
        }

        $now = new \DateTime();
        $dayInSeconds = self::PASSWORD_EXPIRATION * 60 * 60;
        $internal = $now->getTimestamp() - $passwordRequestedAt->getTimestamp();

        if ($internal > $dayInSeconds) {
            $response = false;
        }

        return $response;
    }
}
