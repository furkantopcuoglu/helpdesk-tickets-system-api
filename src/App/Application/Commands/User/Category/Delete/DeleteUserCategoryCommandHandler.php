<?php

namespace App\Application\Commands\User\Category\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class DeleteUserCategoryCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(DeleteUserCategoryCommand $command): true
    {
        $this->entityManager->remove($command->userCategory);
        $this->entityManager->flush();

        return true;
    }
}
