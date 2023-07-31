<?php

namespace App\Application\Commands\Priority\Create;

use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreatePriorityCommand extends TraceableDataTransferObject
{
    public string $name;
    public string $color;
}
