<?php

namespace App\Application\Queries\Status\FindOneBy;

use Common\Domain\Bus\Query\Query;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByStatusQuery extends TraceableDataTransferObject implements Query
{
    public ?string $id;
    public ?string $name;
    public ?string $color;
}
