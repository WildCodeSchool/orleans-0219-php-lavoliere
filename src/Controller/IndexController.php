<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Product;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $productsShowcased = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(['isShowcased' => true]);

        $weekBasketName = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => 'Panier de la semaine']);

        $weekBasket = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findOneBy(['category' => $weekBasketName->getId()]);

        $now = new \DateTime();
        $allActualEvents = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findByActualEvents($now);

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $destination = getenv('MAILTO');
            $sender = getenv('MAILFROM');
            $message = (new \Swift_Message('Contact depuis le site de la Volière'))
                ->setFrom($sender)
                ->setTo($destination)
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',
                        ['contact' => $contact]
                    ),
                    'text/html'
                );
            $mailer->send($message);

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
