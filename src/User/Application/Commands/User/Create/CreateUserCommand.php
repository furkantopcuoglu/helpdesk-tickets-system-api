<?php

namespace User\Application\Commands\User\Create;

use Common\Domain\DataTransferObject\DataTransferObject;

class CreateUserCommand extends DataTransferObject
{
    public string $name;
    public string $surname;
    public string $email;
    public string $password;
    public array $roles = [];
}
