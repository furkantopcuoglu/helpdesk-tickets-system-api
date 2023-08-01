<?php

namespace User\Application\Commands\User\Create;

use User\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommandHandler implements CommandHandler
{
    private ?User $user = null;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateUserCommand $command): CreateUserCommandHandler
    {
        $user = new User();
        $user->setName($command->name);
        $user->setSurname($command->surname);
        $user->setEmail($command->email);
        $user->setRoles($command->roles);
        $user->setCreatedAt(new \DateTime());
        $user->setIsDeleted(false);
        $user->setTokenValidAfter(new \DateTime());
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(null);

        $password = $this->passwordHasher->hashPassword($user, $command->password);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->user = $user;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
