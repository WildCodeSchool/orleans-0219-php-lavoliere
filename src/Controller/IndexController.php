<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Product;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    const BASKET_CATEGORY = 'Panier de la semaine';

    /**
     * @Route("/", name="app_index")
     * @param Request $request
     * @param MailerService $mailer
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request, MailerService $mailer)
    {
        $productsShowcased = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(['isShowcased' => true]);

        $weekBasketName = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => self::BASKET_CATEGORY]);

        if (isset($weekBasketName)) {
            $weekBasket = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findOneBy(['category' => $weekBasketName->getId()]);
        } else {
            $weekBasket = [];
        }
        $now = new \DateTime();
        $allActualEvents = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findByActualEvents($now);

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sender = $this->getParameter('mailer_from');
            $destination = $this->getParameter('mailer_to');

            $bodyMail = $this->renderView('emails/contact.html.twig', ['contact' => $contact]);

            $mailer->sendMail(
                $sender,
                $destination,
                'Contact depuis le site de la Volière',
                'text/html',
                $bodyMail
            );

            $this->addFlash(
                'success',
                'Votre message a bien été envoyé, merci !'
            );

            return $this->redirectToRoute('app_index');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(
                'warning',
                'Veuillez corriger votre formulaire avant l\'envoi.'
            );
        }

        return $this->render('index/index.html.twig', [
            '_fragment' => 'contact-form',
            'productsShowcased' => $productsShowcased,
            'weekBasket' => $weekBasket,
            'allActualEvents' => $allActualEvents,
            'form' => $form->createView(),
        ]);
    }
}
