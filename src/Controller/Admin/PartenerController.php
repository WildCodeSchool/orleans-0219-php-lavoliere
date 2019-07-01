<?php

namespace App\Controller\Admin;

use App\Entity\Partener;
use App\Form\PartenerType;
use App\Repository\PartenerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partenairesAdmin")
 */
class PartenerController extends AbstractController
{
    /**
     * @Route("/", name="partener_index", methods={"GET"})
     */
    public function index(PartenerRepository $partenerRepository): Response
    {
        return $this->render('partener/index.html.twig', [
            'parteners' => $partenerRepository->findAll(),
        ]);
    }
}
