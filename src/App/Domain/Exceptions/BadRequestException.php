<?php

namespace App\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends AbstractApiException
{
    public function __construct(string $message)
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);
    }
}
