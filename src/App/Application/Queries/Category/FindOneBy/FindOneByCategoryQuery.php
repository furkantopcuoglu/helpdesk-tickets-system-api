<?php

namespace App\Application\Queries\Category\FindOneBy;

use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByCategoryQuery extends TraceableDataTransferObject
{
    public ?string $id;
    public ?string $name;
    public ?string $color;
}
