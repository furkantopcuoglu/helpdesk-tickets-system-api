<?php

namespace User\Domain\ValueObjects;

readonly class UserEmail
{
    public function __construct(
        private string $userEmail,
    ) {
    }

    public function getUserEmail(): string
    {
        return $this->userEmail;
    }
}
