<?php

namespace User\Application\Queries\User\Find;

use User\Domain\Entity\User;
use User\Infrastructure\Repositories\Doctrine\UserRepository;

class FindUserQueryHandler
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(FindUserQuery $query): ?User
    {
        return $this->userRepository->findOneBy([
            'id' => $query->getUserId(),
        ]);
    }
}
