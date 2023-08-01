<?php

namespace User\Application\Commands\User\ChangePassword;

use User\Domain\Entity\User;
use Common\Domain\Bus\Command\Command;

class ChangePasswordCommand implements Command
{
    private User $user;
    private string $plainPassword;

    public function __construct(User $user, string $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }
}
