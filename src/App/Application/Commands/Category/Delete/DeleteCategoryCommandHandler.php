<?php

namespace App\Application\Commands\Category\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class DeleteCategoryCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(DeleteCategoryCommand $command): true
    {
        $this->entityManager->remove($command->category);
        $this->entityManager->flush();

        return true;
    }
}
