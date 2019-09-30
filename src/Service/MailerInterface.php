<?php

namespace App\Service;

interface MailerInterface
{
    public function send(
        string $subject,
        string $to,
        string $templateName,
        array $templateVars
    ): int;
}
