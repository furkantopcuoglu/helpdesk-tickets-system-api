<?php

namespace App\Application\Commands\Priority\Delete;

use App\Domain\Entity\Priority;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeletePriorityCommand extends TraceableDataTransferObject
{
    public Priority $priority;
}
