<?php

namespace Support\Application\QueryDto;

use Symfony\Component\Validator\Constraints as Assert;

class SearchTicketQueryDto
{
    public function __construct(
        #[Assert\Optional]
        public ?string $ticketNo,

        #[Assert\Optional]
        public ?string $subject,

        #[Assert\Optional]
        public ?string $content,

        #[Assert\Optional]
        public ?string $priorityId,

        #[Assert\Optional]
        public ?string $categoryId,

        #[Assert\Optional]
        public ?string $statusId,

        #[Assert\Optional]
        public ?string $userId,

        #[Assert\Optional]
        public ?string $supportId,
    ) {
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this), function ($value) {
            return !empty($value);
        });
    }
}
