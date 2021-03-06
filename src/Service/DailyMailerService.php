<?php

namespace App\Service;

use App\Entity\Purchase;
use App\Entity\PurchaseProduct;
use App\Repository\PurchaseProductRepository;
use App\Repository\PurchaseRepository;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Validator\Constraints\Date;
use Twig\Environment;
use Dompdf\Dompdf;
use Dompdf\Options;

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
     * @return string|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function pdfDailyOrderGenerator(
        PurchaseRepository $purchaseRepository,
        PurchaseProductRepository $purchaseProductRepository,
        OrderService $orderService
    ) {
        $purchases = $purchaseRepository->findByActualDayPurchases();
        $nbOrders = count($purchases);

        $productsRecap = $purchaseProductRepository->findAllGroupByNameWithCountAtActualDay();

        $now = new \DateTime();

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->twig->render('emails/dailyMail.html.twig', [
            'purchases' => $purchases,
            'productsRecap' => $productsRecap,
            'nbOrders' => $nbOrders,
            'orderService' => $orderService,
            'now' => $now,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        return $dompdf->stream();
    }

    public function pdfPurchaseGenerator(Purchase $purchase, OrderService $orderService)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->twig->render('emails/pdf_daily_mail.html.twig', [
            'purchase' => $purchase,
            'orderService' => $orderService,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        return $dompdf->stream();
    }


    public function pdfPurchaseGeneratorByDateInterval(
        PurchaseRepository $purchaseRepository,
        PurchaseProductRepository $purchaseProductRepository,
        OrderService $orderService,
        \DateTime $startDate,
        \DateTime $endDate
    ) {

        $purchases = $purchaseRepository->findPurchasesByDateInterval($startDate, $endDate);
        $nbOrders = count($purchases);

        $productsRecap = $purchaseProductRepository->findAllGroupByNameWithCountByDateInterval($startDate, $endDate);

        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->twig->render('emails/pdfMailByDateInterval.html.twig', [
            'purchases' => $purchases,
            'productsRecap' => $productsRecap,
            'nbOrders' => $nbOrders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'orderService' => $orderService,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        return $dompdf->stream();
    }

    /**
     * @param PurchaseRepository $purchaseRepository
     * @param OrderService $orderService
     * @param PurchaseProductRepository $purchaseProductRepository
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function sendDailyMail(
        PurchaseRepository $purchaseRepository,
        OrderService $orderService,
        PurchaseProductRepository $purchaseProductRepository
    ) {
        $purchases = $purchaseRepository->findByActualDayPurchases();
        $nbOrders = count($purchases);

        $productsRecap = $purchaseProductRepository->findAllGroupByNameWithCountAtActualDay();

        $attachments = null;

        $now = new \DateTime();

        foreach ($purchases as $purchase) {
            // Configure Dompdf according to your needs
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');

            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);

            // Retrieve the HTML generated in our twig file
            $html = $this->twig->render('emails/pdf_daily_mail.html.twig', [
                'purchase' => $purchase,
                'orderService' => $orderService,
            ]);

            // Load HTML to Dompdf
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            $attachments[] = $dompdf->output();
        }

        $sender = $this->params->get('mailer_from');
        $destination = $this->params->get('mailer_from');
        $body = $this->twig->render('emails/dailyMail.html.twig', [
            'purchases' => $purchases,
            'productsRecap' => $productsRecap,
            'nbOrders' => $nbOrders,
            'orderService' => $orderService,
            'now' => $now,
        ]);

        $this->mailer->sendMail(
            $sender,
            $destination,
            'Commandes à préparer pour aujourd\'hui !',
            'text/html',
            $body,
            $attachments
        );
    }
}
