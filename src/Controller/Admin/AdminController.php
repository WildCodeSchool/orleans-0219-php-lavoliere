<?php

namespace App\Controller\Admin;

use App\Repository\PurchaseRepository;
use App\Service\DailyMailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/admin/mail", name="admin_mail")
     */
    public function testMail(DailyMailerService $dailyMailerService, PurchaseRepository $purchaseRepository)
    {
        $dailyMailerService->sendDailyMail($purchaseRepository);

        return $this->redirectToRoute('admin');
    }
}
