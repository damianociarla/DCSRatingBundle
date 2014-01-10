<?php

namespace DCS\RatingBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionEventListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($event->getRequest()->isXmlHttpRequest()) {
            $statusCode = 500;
            $message = 'Internal server error';

            if ($exception instanceof HttpException) {
                $statusCode = $exception->getStatusCode();
                $message = $exception->getMessage();
            }

            $response = new JsonResponse();
            $response->setStatusCode($statusCode);
            $response->setData(array(
                'status' => $statusCode,
                'message' => $message,
            ));

            $event->setResponse($response);
        }
    }
}
