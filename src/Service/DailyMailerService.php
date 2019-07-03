<?php

namespace App\Service;

use App\Repository\PurchaseRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;
use Twig\Extension\CoreExtension;

class DailyMailerService
{
    public $mailer;
    private $params;
    private $twig;

    public function __construct(MailerService $mailer, ParameterBagInterface $params, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->params = $params;
        $this->twig = $twig;
    }

    /**
     * @param PurchaseRepository $purchaseRepository
     * @param OrderService $orderService
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendDailyMail(PurchaseRepository $purchaseRepository, OrderService $orderService)
    {
        $purchases = $purchaseRepository->findByActualDayPurchases();
        $nbOrders = count($purchases);

        $now = new \DateTime();

        $sender = $this->params->get('mailer_from');
        $destination = $this->params->get('mailer_from');
        $body = $this->twig->render('emails/dailyMail.html.twig', [
            'purchases' => $purchases,
            'nbOrders' => $nbOrders,
            'orderService' => $orderService,
            'now' => $now,
        ]);

        $this->mailer->sendMail(
            $sender,
            $destination,
            'Commandes à préparer pour aujourd\'hui !',
            'text/html',
            $body
        );
    }
}
