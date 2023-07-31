<?php

namespace App\Application\Commands\Priority\Delete;

use Doctrine\ORM\EntityManagerInterface;

readonly class DeletePriorityCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(DeletePriorityCommand $command): true
    {
        $this->entityManager->remove($command->priority);
        $this->entityManager->flush();

        return true;
    }
}
