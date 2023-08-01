<?php

namespace App\Application\Commands\Status\Create;

use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateStatusCommand extends TraceableDataTransferObject
{
    public string $name;
    public string $color;
}
