<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OurFarmController extends AbstractController
{
    /**
     * @Route("/our-farm", name="our_farm")
     */
    public function index()
    {
        return $this->render('our_farm/index.html.twig');
    }
}
