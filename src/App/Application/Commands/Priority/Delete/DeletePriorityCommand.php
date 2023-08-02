<?php

namespace App\Application\Commands\Priority\Delete;

use App\Domain\Entity\Priority;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeletePriorityCommand extends TraceableDataTransferObject implements Command
{
    public Priority $priority;
}
