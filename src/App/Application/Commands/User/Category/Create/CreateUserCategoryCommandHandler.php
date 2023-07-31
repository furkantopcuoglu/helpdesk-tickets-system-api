<?php

namespace App\Application\Commands\User\Category\Create;

use App\Domain\Entity\UserCategory;
use Doctrine\ORM\EntityManagerInterface;

readonly class CreateUserCategoryCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(CreateUserCategoryCommand $command): UserCategory
    {
        $userCategory = new UserCategory();

        $userCategory->setCategory($command->category);
        $userCategory->setUser($command->user);

        $this->entityManager->persist($userCategory);
        $this->entityManager->flush();

        return $userCategory;
    }
}
