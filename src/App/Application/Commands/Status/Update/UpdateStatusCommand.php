<?php

namespace App\Application\Commands\Status\Update;

use App\Domain\Entity\Status;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdateStatusCommand extends TraceableDataTransferObject implements Command
{
    public Status $status;
    public ?string $name;
    public ?string $color;
}
