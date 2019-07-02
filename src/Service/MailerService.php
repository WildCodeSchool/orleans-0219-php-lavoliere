<?php


namespace App\Service;

class MailerService
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(string $from, string $to, string $subject, string $format, $body, $attachmentFile = null)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody($body, $format);

        if ($attachmentFile) {
            $attachment = new \Swift_Attachment($attachmentFile, 'order-file.pdf', 'application/pdf');
            $message->attach($attachment);
        }

        return $this->mailer->send($message);
    }


    public function createBodyMail($view, array $parameters)
    {
        return $this->mailer->renderView($view, $parameters);
    }
}
