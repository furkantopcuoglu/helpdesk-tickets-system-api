<?php

namespace App\Application\Commands\Priority\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class DeletePriorityCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(DeletePriorityCommand $command): true
    {
        $this->entityManager->remove($command->priority);
        $this->entityManager->flush();

        return true;
    }
}
