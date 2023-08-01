<?php

namespace App\Application\Queries\Status\FindOneBy;

use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByStatusQuery extends TraceableDataTransferObject
{
    public ?string $id;
    public ?string $name;
    public ?string $color;
}
