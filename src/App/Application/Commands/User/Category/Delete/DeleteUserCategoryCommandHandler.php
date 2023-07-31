<?php

namespace App\Application\Commands\User\Category\Delete;

use Doctrine\ORM\EntityManagerInterface;

readonly class DeleteUserCategoryCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(DeleteUserCategoryCommand $command): true
    {
        $this->entityManager->remove($command->userCategory);
        $this->entityManager->flush();

        return true;
    }
}
