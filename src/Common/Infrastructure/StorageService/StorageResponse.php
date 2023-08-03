<?php

namespace Common\Infrastructure\StorageService;

use Common\Domain\DataTransferObject\DataTransferObject;

class StorageResponse extends DataTransferObject
{
    public ?string $fileName;
    public ?string $path;
    public ?string $url;
}
