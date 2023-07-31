<?php

namespace App\Domain\ValueObjects;

class PriorityId
{
    public string $priorityId;

    public function __construct(string $priorityId)
    {
        $this->priorityId = $priorityId;
    }

    public function getPriorityId(): string
    {
        return $this->priorityId;
    }
}
