<?php

namespace User\Application\Queries\User\FindByEmail;

use User\Domain\Entity\User;
use User\Domain\Repository\UserRepositoryInterface;

readonly class FindUserByEmailQueryHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function handle(FindUserByEmailQuery $query): ?User
    {
        return $this->userRepository->findOneBy([
            'email' => $query->getUserEmail(),
        ]);
    }
}
