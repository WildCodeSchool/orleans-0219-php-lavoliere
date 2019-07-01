<?php

namespace App\Service;

use App\Repository\PurchaseRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Templating\EngineInterface;

class DailyMailerService
{
    private $mailer;
    private $params;
    private $templating;

    public function __construct(MailerService $mailer, ParameterBagInterface $params, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->params = $params;
        $this->templating = $templating;
    }

    public function sendDailyMail(PurchaseRepository $purchaseRepository)
    {
        $orders = $purchaseRepository->findActualDayOrders();

        $sender = $this->params->get('mailer_from');
        $destination = $this->params->get('mailer_from');
        $body = $this->templating->render('emails/dailyMail.html.twig', ['orders' => $orders]);

        $this->mailer->sendMail(
            $sender,
            $destination,
            'Commandes à préparer pour aujourdh\'ui !',
            'text/html',
            $body
        );
    }
}
