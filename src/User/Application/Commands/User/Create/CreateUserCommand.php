<?php

namespace User\Application\Commands\User\Create;

use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\DataTransferObject;

class CreateUserCommand extends DataTransferObject implements Command
{
    public string $name;
    public string $surname;
    public string $email;
    public string $password;
    public array $roles = [];
}
