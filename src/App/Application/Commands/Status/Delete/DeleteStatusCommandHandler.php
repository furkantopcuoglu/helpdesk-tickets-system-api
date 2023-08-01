<?php

namespace App\Application\Commands\Status\Delete;

use Doctrine\ORM\EntityManagerInterface;

readonly class DeleteStatusCommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function handle(DeleteStatusCommand $command): true
    {
        $this->entityManager->remove($command->status);
        $this->entityManager->flush();

        return true;
    }
}
