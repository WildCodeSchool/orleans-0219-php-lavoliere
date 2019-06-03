<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index()
    {
        $productsShowcased = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findBy(['isShowcased' => true]);

        return $this->render('index/index.html.twig', [
            'productsShowcased' => $productsShowcased,
        ]);
    }
}
