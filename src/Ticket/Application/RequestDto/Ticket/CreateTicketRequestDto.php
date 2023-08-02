<?php

namespace Ticket\Application\RequestDto\Ticket;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

readonly class CreateTicketRequestDto
{
    public function __construct(
        #[Assert\Optional]
        public ?string $subject,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 40)]
        public string $name,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 40)]
        public string $surname,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\PasswordStrength([
            'minScore' => PasswordStrength::STRENGTH_MEDIUM,
        ])]
        public string $password,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
