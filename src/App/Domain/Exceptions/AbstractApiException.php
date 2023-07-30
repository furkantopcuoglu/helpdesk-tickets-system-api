<?php

namespace App\Domain\Exceptions;

class AbstractApiException extends \Exception implements ApiExceptionInterface
{
    private array $errors = [];

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    public function addError(string|int $key, mixed $error): void
    {
        $this->errors[$key] = $error;
    }
}
