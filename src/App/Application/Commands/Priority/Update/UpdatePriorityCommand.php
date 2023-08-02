<?php

namespace App\Application\Commands\Priority\Update;

use App\Domain\Entity\Priority;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdatePriorityCommand extends TraceableDataTransferObject implements Command
{
    public Priority $priority;
    public ?string $name;
    public ?string $color;
}
