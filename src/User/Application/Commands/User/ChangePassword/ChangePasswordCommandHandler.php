<?php

namespace User\Application\Commands\User\ChangePassword;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class ChangePasswordCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(ChangePasswordCommand $command): User
    {
        $password = $this->passwordHasher->hashPassword(
            $command->getUser(),
            $command->getPlainPassword(),
        );

        $command->getUser()->setPassword($password);
        $command->getUser()->setUpdatedAt(new \DateTime());
        $command->getUser()->setTokenValidAfter(new \DateTime());

        $this->entityManager->flush();

        return $command->getUser();
    }
}
