<?php

namespace App\Application\Commands\Status\Create;

use App\Domain\Entity\Status;
use Doctrine\ORM\EntityManagerInterface;
use Common\Domain\Bus\Command\CommandHandler;

readonly class CreateStatusCommandHandler implements CommandHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(CreateStatusCommand $command): Status
    {
        $status = new Status();

        $status->setName($command->name);
        $status->setColor($command->color);

        $this->entityManager->persist($status);
        $this->entityManager->flush();

        return $status;
    }
}
