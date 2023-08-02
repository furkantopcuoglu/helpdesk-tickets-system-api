<?php

namespace App\Application\Commands\Category\Create;

use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateCategoryCommand extends TraceableDataTransferObject implements Command
{
    public string $name;
    public string $color;
    public bool $isDefault = true;
}
