<?php

namespace App\Application\RequestDto\Media;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateMediaRequestDto
{
    public function __construct(
        #[Assert\NotNull]
        #[Assert\NotBlank]
        #[Assert\Regex(
            pattern: '/^data:(image\/\w+);base64,/',
            message: 'BAD_REQUEST_BASE64_FORMAT',
        )]
        public string $file,
    ) {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
