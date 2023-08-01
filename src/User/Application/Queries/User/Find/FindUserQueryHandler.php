<?php

namespace User\Application\Queries\User\Find;

use User\Domain\Entity\User;
use Common\Domain\Bus\Query\QueryHandler;
use User\Infrastructure\Repositories\Doctrine\UserRepository;

class FindUserQueryHandler implements QueryHandler
{
    private UserRepository $userRepository;

    public function __construct(
        UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }

    public function __invoke(FindUserQuery $query): ?User
    {
        return $this->userRepository->findOneBy([
            'id' => $query->getUserId(),
        ]);
    }
}
