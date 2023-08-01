<?php

namespace User\Application\Commands\User\Banned;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class BannedUserCommandHandler implements CommandHandler
{
    public function __construct(
        public EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(BannedUserCommand $command): User
    {
        $user = $command->user;

        $user->setIsActive(false);
        $user->setTokenValidAfter(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
