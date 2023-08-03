<?php

namespace App\Application\RequestDto\Category;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateCustomUserCategoryRequestDto
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 40)]
        public string $name,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
