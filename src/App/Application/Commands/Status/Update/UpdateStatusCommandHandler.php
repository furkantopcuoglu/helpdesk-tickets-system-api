<?php

namespace App\Application\Commands\Status\Update;

use App\Domain\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class UpdateStatusCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(UpdateStatusCommand $command): Status
    {
        $status = $command->status;

        if ($command->hasParameter('name')) {
            $status->setName($command->name);
        }

        if ($command->hasParameter('color')) {
            $status->setColor($command->color);
        }

        $this->entityManager->persist($status);
        $this->entityManager->flush();

        return $status;
    }
}
