<?php

namespace User\Application\Commands\User\Update;

use User\Domain\Entity\User;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdateUserCommand extends TraceableDataTransferObject implements Command
{
    public User $user;

    public ?string $name;
    public ?string $surname;
    public ?string $email;
    public ?bool $isDeleted;
    public ?array $roles;
}
