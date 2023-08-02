<?php

namespace User\Application\Commands\User\Recovery;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class RecoveryUserCommandHandler implements CommandHandler
{
    public function __construct(
        public EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(RecoveryUserCommand $command): User
    {
        $user = $command->user;

        $user->setIsDeleted(false);
        $user->setDeletedBy(null);
        $user->setDeletedAt(null);
        $user->setTokenValidAfter(new \DateTime());
        $user->setIsActive(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
