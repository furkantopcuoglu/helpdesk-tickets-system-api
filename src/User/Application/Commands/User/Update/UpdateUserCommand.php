<?php

namespace User\Application\Commands\User\Update;

use User\Domain\Entity\User;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdateUserCommand extends TraceableDataTransferObject
{
    public User $user;

    public ?string $name;
    public ?string $surname;
    public ?string $email;
    public ?bool $isDeleted;
    public ?array $roles;
}
