<?php

namespace Ticket\Application\Commands\Ticket\Create;

use User\Domain\Entity\User;
use App\Domain\Entity\Category;
use App\Domain\Entity\Priority;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateTicketCommand extends TraceableDataTransferObject implements Command
{
    public string $subject;
    public string $content;
    public Priority $priority;
    public User $owner;
    public Category $category;
    public ?array $files = null;
}
