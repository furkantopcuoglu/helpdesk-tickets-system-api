<?php

namespace App\Domain\ValueObjects;

class StatusId
{
    public string $statusId;

    public function __construct(string $statusId)
    {
        $this->statusId = $statusId;
    }

    public function getStatusId(): string
    {
        return $this->statusId;
    }
}
