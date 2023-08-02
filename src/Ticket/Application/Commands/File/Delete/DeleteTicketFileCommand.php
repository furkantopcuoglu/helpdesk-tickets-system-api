<?php

namespace Ticket\Application\Commands\File\Delete;

use User\Domain\Entity\User;
use Ticket\Domain\Entity\TicketFile;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteTicketFileCommand extends TraceableDataTransferObject implements Command
{
    public TicketFile $ticketFile;
    public User $user;
}
