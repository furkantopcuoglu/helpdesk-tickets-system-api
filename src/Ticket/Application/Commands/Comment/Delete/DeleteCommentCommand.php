<?php

namespace Ticket\Application\Commands\Comment\Delete;

use User\Domain\Entity\User;
use Common\Domain\Bus\Command\Command;
use Ticket\Domain\Entity\TicketComment;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteCommentCommand extends TraceableDataTransferObject implements Command
{
    public TicketComment $ticketComment;
    public User $user;
}
