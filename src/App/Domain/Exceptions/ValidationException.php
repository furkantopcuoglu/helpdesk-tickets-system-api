<?php

namespace App\Domain\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class ValidationException extends AbstractApiException
{
    public function __construct(array $violations)
    {
        parent::__construct(code: Response::HTTP_BAD_REQUEST);

        $this->setErrors($violations);
    }
}
