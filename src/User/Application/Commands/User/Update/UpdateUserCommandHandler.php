<?php

namespace User\Application\Commands\User\Update;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class UpdateUserCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateUserCommand $command): User
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
