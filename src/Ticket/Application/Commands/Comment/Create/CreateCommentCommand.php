<?php

namespace Ticket\Application\Commands\Comment\Create;

use User\Domain\Entity\User;
use Ticket\Domain\Entity\Ticket;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateCommentCommand extends TraceableDataTransferObject implements Command
{
    public string $content;
    public User $user;
    public Ticket $ticket;
}
