<?php

namespace User\Application\Commands\User\ChangePassword;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class ChangePasswordCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function handle(ChangePasswordCommand $command): User
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
