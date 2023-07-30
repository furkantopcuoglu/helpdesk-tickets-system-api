<?php

namespace App\Domain\Exceptions;

interface ApiExceptionInterface
{
    public function getMessage(): string;

    public function getCode();

    public function getErrors(): array;

    public function setErrors(array $errors): void;

    public function addError(string|int $key, mixed $error): void;
}
