<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Service\Exception\Exception;
use App\Service\Exception\ExceptionData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        /** @var Exception $exception */
        $exception = $event->getThrowable();





        if ($exception instanceof HttpExceptionInterface) {
            $exceptionData = $exception->getExceptionData();
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $exceptionData = new ExceptionData($statusCode, $exception->getMessage());
        }
        $response = new JsonResponse($exceptionData->toArray());
        $event->setResponse($response);
    }
}