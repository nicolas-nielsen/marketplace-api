<?php

declare(strict_types=1);

namespace App\Application\ErrorHandling;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class HttpExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$event->getThrowable() instanceof HttpException) {
            return;
        }

        $event->setResponse(new JsonResponse(
            [
                'code' => $event->getThrowable()->getStatusCode(),
                'message' => $event->getThrowable()->getMessage(),
            ],
            $event->getThrowable()->getStatusCode(),
        ));
    }
}
