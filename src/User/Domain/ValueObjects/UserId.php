<?php

namespace User\Domain\ValueObjects;

class UserId
{
    public function __construct(
        private readonly string $userId,
    ) {
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
