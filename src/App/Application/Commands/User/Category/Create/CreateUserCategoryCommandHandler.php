<?php

namespace App\Application\Commands\User\Category\Create;

use App\Domain\Entity\UserCategory;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class CreateUserCategoryCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateUserCategoryCommand $command): UserCategory
    {
        $userCategory = new UserCategory();

        $userCategory->setCategory($command->category);
        $userCategory->setUser($command->user);

        $this->entityManager->persist($userCategory);
        $this->entityManager->flush();

        return $userCategory;
    }
}
