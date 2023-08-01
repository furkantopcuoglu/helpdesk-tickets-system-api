<?php

namespace User\Application\Queries\User\FindByEmail;

use User\Domain\Entity\User;
use Common\Domain\Bus\Query\QueryHandler;
use User\Domain\Repository\UserRepositoryInterface;

readonly class FindUserByEmailQueryHandler implements QueryHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(FindUserByEmailQuery $query): ?User
    {
        return $this->userRepository->findOneBy([
            'email' => $query->getUserEmail(),
        ]);
    }
}
