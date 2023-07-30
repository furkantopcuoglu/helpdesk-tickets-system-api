<?php

namespace App\Application\EventListener\Exception;

use Common\Application\Utils\Payload;
use Aura\Payload_Interface\PayloadStatus;
use App\Domain\Exceptions\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Domain\Exceptions\ApiExceptionInterface;
use Nelmio\CorsBundle\Options\ResolverInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Common\Application\Utils\ValidatorMessageFormatter;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ExceptionListener
{
    public function __construct(
        protected ParameterBagInterface $parameterBag,
        protected ResolverInterface $configurationResolver,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = match (true) {
            ($exception instanceof ApiExceptionInterface) => $this->getApiExceptionResponse($exception),
            ($exception instanceof HttpExceptionInterface) => $this->getHttpExceptionResponse($exception),
            default => $this->getThrowableExceptionResponse($exception),
        };

        $event->setResponse($response);
    }

    protected function getApiExceptionResponse(ApiExceptionInterface $exception): JsonResponse
    {
        $messages = match (true) {
            ($exception instanceof ValidationException) => $exception->getErrors(),
            default => [$exception->getMessage()],
        };

        $payload = $this->getDefaultPayload();
        $payload->setMessages($messages);

        return new JsonResponse($payload->toArray(), $exception->getCode());
    }

    protected function getHttpExceptionResponse(HttpExceptionInterface $exception): JsonResponse
    {
        if ($exception->getStatusCode() >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            return $this->getThrowableExceptionResponse($exception);
        }

        $payload = $this->getDefaultPayload();

        $previous = $exception->getPrevious();

        if ($previous instanceof ValidationFailedException) {
            $payload->setMessages(ValidatorMessageFormatter::format($previous->getViolations()));

            return new JsonResponse($payload->toArray(), $exception->getStatusCode());
        }

        $payload->addMessage($exception->getMessage());

        return new JsonResponse($payload->toArray(), $exception->getStatusCode());
    }

    protected function getThrowableExceptionResponse(\Throwable $exception): JsonResponse
    {
        $payload = $this->getDefaultPayload();
        $payload->addMessage($exception->getMessage());

        return new JsonResponse($payload->toArray(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function getDefaultPayload(): Payload
    {
        return (new Payload())
            ->setStatus(PayloadStatus::ERROR);
    }
}
