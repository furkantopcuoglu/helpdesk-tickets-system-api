<?php

namespace App\Application\Queries\Category\List;

use Common\Domain\Bus\Query\Query;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class ListCategoryQuery extends TraceableDataTransferObject implements Query
{
    public ?bool $isDefault;
}
