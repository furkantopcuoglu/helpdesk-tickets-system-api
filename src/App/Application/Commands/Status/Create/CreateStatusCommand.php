<?php

namespace App\Application\Commands\Status\Create;

use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateStatusCommand extends TraceableDataTransferObject implements Command
{
    public string $name;
    public string $color;
}
