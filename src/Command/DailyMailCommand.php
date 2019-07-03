<?php

namespace App\Command;

use App\Repository\PurchaseRepository;
use App\Service\DailyMailerService;
use App\Service\OrderService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DailyMailCommand extends Command
{
    protected static $defaultName = 'app:daily-mail';
    public $dailyMailer;
    public $purchaseRepository;
    public $orderService;

    /**
     * DailyMailCommand constructor.
     * @param DailyMailerService $dailyMailerService
     * @param PurchaseRepository $purchaseRepository
     * @param OrderService $orderService
     * @param string|null $name
     */
    public function __construct(
        DailyMailerService $dailyMailerService,
        PurchaseRepository $purchaseRepository,
        OrderService $orderService,
        string $name = null
    ) {
        $this->dailyMailer = $dailyMailerService;
        $this->orderService = $orderService;
        $this->purchaseRepository = $purchaseRepository;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('This command is used for sen daily mail to the client with all his future orders')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dailyMailer->sendDailyMail($this->purchaseRepository, $this->orderService);
    }
}
