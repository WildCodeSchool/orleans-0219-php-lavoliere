<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Form\ChangePasswordType;
use App\Repository\PurchaseRepository;
use App\Service\OrderService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use App\Form\UserInformationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AccountController
 * @package App\Controller
 * @Route("/mon-compte")
 */
class AccountController extends AbstractController
{
    /**
     * @Route("/accueil", name="app_account")
     * @IsGranted("ROLE_USER")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/changer-mot-de-passe", name="change_password_account")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $oldPassword = $form->get('oldPassword')->getData();

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
                $user->setPassword($newEncodedPassword);
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été modifié.');

                return $this->redirectToRoute('app_account');
            }

            $form->addError(new FormError('Ancien mot de passe incorrect'));
        }

        return $this->render('account/change_password.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/edition", name="account_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
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

            $this->addFlash('success', 'Vos informations ont bien été modifiées.');
            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/edit_account.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/historique-commande", name="account_history")
     */
    public function seeHistory(
        OrderService $orderService,
        PurchaseRepository $purchaseRepository
    ) {
        $user = $this->getUser();

        $purchases = $purchaseRepository->findPurchasesByDescOrderDate($user);

        return $this->render('account/history.html.twig', [
            'user' => $user,
            'purchases' => $purchases,
            'total' => $orderService,
        ]);
    }


    public function checkConnected()
    {
        $user = $this->getUser();

        return $this->render('_navbar_check_connected.html.twig', [
            'user' => $user
        ]);
    }
}
