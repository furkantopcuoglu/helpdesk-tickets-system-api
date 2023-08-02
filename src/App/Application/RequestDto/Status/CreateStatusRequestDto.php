<?php

namespace App\Application\RequestDto\Status;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateStatusRequestDto
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 40)]
        public string $name,

        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 40)]
        public string $color,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
