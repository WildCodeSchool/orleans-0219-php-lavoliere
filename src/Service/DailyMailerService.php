<?php

namespace App\Service;

class DailyMailerService
{
    public $mailer;

    public function __construct(MailerService $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendDailyMail()
    {
    }
}
