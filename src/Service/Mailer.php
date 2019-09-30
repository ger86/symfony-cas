<?php

namespace App\Service;

use Twig\Environment as Twig;

class Mailer implements MailerInterface
{
    private $mailer;
    private $twig;
    private $mailFrom;

    public function __construct(\Swift_Mailer $mailer, Twig $twig, string $mailFrom)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
    }

    public function send(
        string $subject,
        string $to,
        string $templateName,
        array $templateVars
    ): int {
        $message = (new \Swift_Message($subject))
            ->setFrom($this->mailFrom)
            ->setTo($to)
            ->setBody(
                $this->twig->render($templateName, $templateVars),
                'text/html'
            );
        return $this->mailer->send($message);
    }
}
