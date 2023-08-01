<?php

namespace App\Application\Commands\Status\Delete;

use App\Domain\Entity\Status;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteStatusCommand extends TraceableDataTransferObject
{
    public Status $status;
}
