<?php

namespace User\Application\Commands\User\Delete;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class DeleteUserCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(DeleteUserCommand $command): User
    {
        $user = $command->user;

        $user->setIsDeleted(true);
        $user->setDeletedBy($command->deletedBy);
        $user->setDeletedAt(new \DateTime());
        $user->setTokenValidAfter(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
