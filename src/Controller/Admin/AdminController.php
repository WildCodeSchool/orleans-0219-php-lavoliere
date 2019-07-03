<?php

namespace App\Controller\Admin;

use App\Repository\PurchaseRepository;
use App\Service\DailyMailerService;
use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @param PurchaseRepository $purchaseRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(PurchaseRepository $purchaseRepository)
    {
        $purchases = $purchaseRepository->findByActualDayPurchases();
        $nbOrders = count($purchases);

        return $this->render('admin/index.html.twig', [
            'nbOrders' => $nbOrders,
            'purchases' => $purchases,
            ]);
    }

    /**
     * @Route("/admin/commande-pdf" , name="pdf_daily_orders")
     * @param DailyMailerService $dailyMailerService
     * @param PurchaseRepository $purchaseRepository
     * @param OrderService $orderService
     * @return string|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function pdfGenerator(
        DailyMailerService $dailyMailerService,
        PurchaseRepository $purchaseRepository,
        OrderService $orderService
    ) {
        return $dailyMailerService->pdfDailyOrderGenerator($purchaseRepository, $orderService);
    }
}
