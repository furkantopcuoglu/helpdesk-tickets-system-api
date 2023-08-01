<?php

namespace App\Application\Commands\Status\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class DeleteStatusCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(DeleteStatusCommand $command): true
    {
        $this->entityManager->remove($command->status);
        $this->entityManager->flush();

        return true;
    }
}
