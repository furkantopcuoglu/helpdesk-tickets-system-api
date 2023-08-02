<?php

namespace App\Application\EventListener;

use Common\Application\Utils\Payload;
use Aura\Payload_Interface\PayloadStatus;
use Aura\Payload_Interface\PayloadInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonResponseListener
{
    public function __invoke(ViewEvent $event): void
    {
        $response = $event->getControllerResult();

        if ($response instanceof Payload) {
            $statusCode = $this->getStatusCode($response);

            $event->setResponse(new JsonResponse($response->toArray(), $statusCode));

            return;
        }

        if (Request::METHOD_DELETE === $event->getRequest()->getMethod()) {
            $event->setResponse(new JsonResponse(null, Response::HTTP_NO_CONTENT));

            return;
        }

        $event->setResponse($response);
    }

    /**
     * Some responses are handling via following exceptions with specified status codes.
     *
     * @see ValidationException for Response::HTTP_BAD_REQUEST
     * @see AuthorizationException for Response::HTTP_UNAUTHORIZED
     * @see NotFoundException for Response::HTTP_NOT_FOUND
     * @see BadRequestException for Response::HTTP_BAD_REQUEST
     * @see FailedOperationException for Response::HTTP_SERVICE_UNAVAILABLE
     */
    private function getStatusCode(PayloadInterface $payload): int
    {
        return match ($payload->getStatus()) {
            PayloadStatus::CREATED => Response::HTTP_CREATED,
            PayloadStatus::DELETED => Response::HTTP_NO_CONTENT,
            default => Response::HTTP_OK,
        };
    }
}
