<?php

namespace Ticket\Application\RequestDto\Ticket;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateTicketRequestDto
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\NotBlank]
        public string $subject,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        public string $content,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $priorityId,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $categoryId,

        #[Assert\Optional]
        #[Assert\Count(
            min: 1,
            max: 3,
        )]
        #[Assert\All(constraints: new Assert\Uuid())]
        public ?array $files,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
