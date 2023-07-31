<?php

namespace App\Application\Commands\Priority\Update;

use App\Domain\Entity\Priority;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdatePriorityCommand extends TraceableDataTransferObject
{
    public Priority $priority;
    public ?string $name;
    public ?string $color;
}
