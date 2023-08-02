<?php

namespace App\Application\Commands\Status\Delete;

use App\Domain\Entity\Status;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteStatusCommand extends TraceableDataTransferObject implements Command
{
    public Status $status;
}
