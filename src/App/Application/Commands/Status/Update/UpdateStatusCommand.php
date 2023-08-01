<?php

namespace App\Application\Commands\Status\Update;

use App\Domain\Entity\Status;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdateStatusCommand extends TraceableDataTransferObject
{
    public Status $status;
    public ?string $name;
    public ?string $color;
}
