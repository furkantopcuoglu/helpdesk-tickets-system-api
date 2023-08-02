<?php

namespace App\Application\Commands\Priority\Create;

use App\Domain\Entity\Priority;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class CreatePriorityCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreatePriorityCommand $command): Priority
    {
        $priority = new Priority();

        $priority->setName($command->name);
        $priority->setColor($command->color);

        $this->entityManager->persist($priority);
        $this->entityManager->flush();

        return $priority;
    }
}
