<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OurFarmController extends AbstractController
{
    /**
     * @Route("/notre-ferme", name="our_farm", methods={"GET"})
     */
    public function index(LocationRepository $locationRepository)
    {

        return $this->render('our_farm/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }
}
