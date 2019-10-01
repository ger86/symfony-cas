<?php

namespace App\EventSubscriber;

use App\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{

    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::EXCEPTION => [
                ['mailException', 10],
            ],
        ];
    }

    public function mailException(ExceptionEvent $event)
    {
        $this->mailer->send(
            'Una excepción sucedió',
            'gerardo@latteandcode.com',
            'mails/exception.html.twig',
            ['exception' => $event->getException()]
        );
    }
}
