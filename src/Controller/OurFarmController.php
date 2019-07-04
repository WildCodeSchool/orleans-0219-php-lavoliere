<?php

namespace App\Controller;

use App\Controller\Admin\PartnerController;
use App\Entity\Location;
use App\Repository\LocationRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OurFarmController extends AbstractController
{
    /**
     * @Route("/notre-ferme", name="our_farm", methods={"GET"})
     */
    public function index(LocationRepository $locationRepository, PartnerRepository $partnerRepository)
    {

        return $this->render('our_farm/index.html.twig', [
            'locations' => $locationRepository->findAll(),
            'partners' => $partnerRepository->findAll(),
        ]);
    }
}
