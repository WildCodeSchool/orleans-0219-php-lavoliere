<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DailyMailController extends AbstractController
{
    /**
     * @Route("/daily/mail", name="daily_mail")
     */
    public function index()
    {
        return $this->render('daily_mail/index.html.twig', [
            'controller_name' => 'DailyMailController',
        ]);
    }
}
