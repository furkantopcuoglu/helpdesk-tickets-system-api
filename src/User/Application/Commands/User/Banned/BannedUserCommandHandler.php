<?php

namespace User\Application\Commands\User\Banned;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class BannedUserCommandHandler
{
    public function __construct(
        public EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(BannedUserCommand $command): User
    {
        $user = $command->user;

        $user->setIsActive(false);
        $user->setTokenValidAfter(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
