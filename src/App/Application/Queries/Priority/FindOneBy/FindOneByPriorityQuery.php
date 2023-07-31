<?php

namespace App\Application\Queries\Priority\FindOneBy;

use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByPriorityQuery extends TraceableDataTransferObject
{
    public ?string $id;
    public ?string $name;
    public ?string $color;
}
