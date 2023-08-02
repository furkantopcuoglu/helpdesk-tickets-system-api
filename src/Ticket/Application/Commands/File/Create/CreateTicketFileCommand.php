<?php

namespace Ticket\Application\Commands\File\Create;

use Common\Domain\Entity\Media;
use Ticket\Domain\Entity\Ticket;
use Common\Domain\Bus\Command\Command;
use Ticket\Domain\Entity\TicketComment;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateTicketFileCommand extends TraceableDataTransferObject implements Command
{
    public ?Ticket $ticket;
    public ?TicketComment $ticketComment;
    public Media $media;
}
