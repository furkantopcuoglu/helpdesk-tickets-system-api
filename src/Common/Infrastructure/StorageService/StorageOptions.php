<?php

namespace Common\Infrastructure\StorageService;

use User\Domain\Entity\User;
use Common\Domain\DataTransferObject\DataTransferObject;

class StorageOptions extends DataTransferObject
{
    public User $user;
    public string $file;
    public ?string $path;
}
