<?php

namespace App\Application\Commands\Category\Create;

use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateCategoryCommand extends TraceableDataTransferObject
{
    public string $name;
    public string $color;
    public bool $isDefault;
}
