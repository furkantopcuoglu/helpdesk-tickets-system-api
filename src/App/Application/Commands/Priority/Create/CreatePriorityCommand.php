<?php

namespace App\Application\Commands\Priority\Create;

use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreatePriorityCommand extends TraceableDataTransferObject implements Command
{
    public string $name;
    public string $color;
}
