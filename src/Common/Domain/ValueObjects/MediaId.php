<?php

namespace Common\Domain\ValueObjects;

class MediaId
{
    public function __construct(
        private readonly string $mediaId,
    ) {
    }

    public function getMediaId(): string
    {
        return $this->mediaId;
    }
}
