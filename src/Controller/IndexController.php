<?php

namespace App\Controller;

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

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $destination = getenv('MAIL');
            $message = (new \Swift_Message('Contact depuis le site de la Volière'))
                ->setFrom($destination)
                ->setTo('paulvinny@gmail.com')
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',
                        ['contact' => $contact]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            return $this->redirectToRoute('app_index');
        }


        return $this->render('index/index.html.twig', [
            'productsShowcased' => $productsShowcased,
            'controller_name' => 'IndexController',
            'form' => $form->createView(),
        ]);
    }
}
