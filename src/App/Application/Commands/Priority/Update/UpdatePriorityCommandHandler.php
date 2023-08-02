<?php

namespace App\Application\Commands\Priority\Update;

use App\Domain\Entity\Priority;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class UpdatePriorityCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdatePriorityCommand $command): Priority
    {
        $priority = $command->priority;

        if ($command->hasParameter('name')) {
            $priority->setName($command->name);
        }

        if ($command->hasParameter('color')) {
            $priority->setColor($command->color);
        }

        $this->entityManager->persist($priority);
        $this->entityManager->flush();

        return $priority;
    }
}
