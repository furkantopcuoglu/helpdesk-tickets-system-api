<?php

namespace User\Application\Commands\User\Update;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class UpdateUserCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(UpdateUserCommand $command): User
    {
        $user = $command->user;

        if ($command->hasParameter('name')) {
            $user->setName($command->name);
        }

        if ($command->hasParameter('surname')) {
            $user->setSurname($command->surname);
        }

        if ($command->hasParameter('email')) {
            $user->setEmail($command->email);
        }

        if ($command->hasParameter('isDeleted')) {
            $user->setIsDeleted($command->isDeleted);
        }

        if ($command->hasParameter('roles')) {
            $user->setRoles($command->roles);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
