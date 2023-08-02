<?php

namespace App\Application\Queries\Priority\FindOneBy;

use Common\Domain\Bus\Query\Query;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByPriorityQuery extends TraceableDataTransferObject implements Query
{
    public ?string $id;
    public ?string $name;
    public ?string $color;
}
