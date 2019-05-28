<?php

namespace App\Controller;

use App\Form\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = new Contact();
        $form = $this->createForm(Contact::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $destination = getenv('MAIL');
            $message = (new \Swift_Message('Contact depuis le site de la Volière'))
                ->setFrom($destination)
                ->setTo('paulvinny@gmail.com')
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',
                        ['form' => $form->getData()]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            return $this->redirectToRoute('index');
        }


        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'form' => $form->createView(),
        ]);
    }
}
