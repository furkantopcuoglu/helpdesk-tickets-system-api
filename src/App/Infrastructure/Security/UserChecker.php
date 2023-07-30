<?php

namespace App\Infrastructure\Security;

use User\Domain\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!($user instanceof User)) {
            throw new CustomUserMessageAccountStatusException('UserInterface must be an instance of User');
        }

        if (!$user->isActive()) {
            throw new CustomUserMessageAccountStatusException('Your account is not active');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // todo last login date
    }
}
