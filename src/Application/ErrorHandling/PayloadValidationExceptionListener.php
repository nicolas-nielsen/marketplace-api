<?php

declare(strict_types=1);

namespace App\Application\ErrorHandling;

use App\Application\Payload\Exception\PayloadValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PayloadValidationExceptionListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$event->getThrowable() instanceof PayloadValidationException) {
            return;
        }

        /** @var PayloadValidationException $payloadValidationException */
        $payloadValidationException = $event->getThrowable();

        $errors = [];
        foreach ($payloadValidationException->getConstraintViolationList() as $constraintViolation) {
            $errors[] = [$constraintViolation->getPropertyPath() => $constraintViolation->getMessage()];
        }

        $event->setResponse(new JsonResponse(
            [
                'code' => Response::HTTP_BAD_REQUEST,
                'validation_errors' => $errors,
            ],
            Response::HTTP_BAD_REQUEST,
        ));
    }
}
