<?php

namespace Ticket\Application\Commands\Ticket\Update;

use User\Domain\Entity\User;
use App\Domain\Entity\Status;
use App\Domain\Entity\Category;
use App\Domain\Entity\Priority;
use Ticket\Domain\Entity\Ticket;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdateTicketCommand extends TraceableDataTransferObject implements Command
{
    public Ticket $ticket;
    public ?string $subject;
    public ?string $content;
    public User $updatedBy;
    public ?User $support;
    public ?Status $status;
    public ?Priority $priority;
    public ?Category $category;
    public ?bool $isCompleted;
    public ?bool $isDeleted;
    public ?bool $isArchive;
}
