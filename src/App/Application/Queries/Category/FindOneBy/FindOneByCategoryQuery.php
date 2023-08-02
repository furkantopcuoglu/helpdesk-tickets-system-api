<?php

namespace App\Application\Queries\Category\FindOneBy;

use Common\Domain\Bus\Query\Query;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByCategoryQuery extends TraceableDataTransferObject implements Query
{
    public ?string $id;
    public ?string $name;
    public ?string $color;
}
