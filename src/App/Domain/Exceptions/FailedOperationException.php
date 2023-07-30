<?php

namespace App\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class FailedOperationException extends AbstractApiException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_SERVICE_UNAVAILABLE);
    }
}
