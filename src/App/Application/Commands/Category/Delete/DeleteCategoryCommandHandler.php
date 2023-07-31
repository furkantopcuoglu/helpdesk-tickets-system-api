<?php

namespace App\Application\Commands\Category\Delete;

use Doctrine\ORM\EntityManagerInterface;

readonly class DeleteCategoryCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(DeleteCategoryCommand $command): true
    {
        $this->entityManager->remove($command->category);
        $this->entityManager->flush();

        return true;
    }
}
