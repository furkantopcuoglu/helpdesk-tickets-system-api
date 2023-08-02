<?php

namespace App\Application\Queries\Priority\Find;

use Common\Domain\Bus\Query\Query;
use App\Domain\ValueObjects\PriorityId;

class FindPriorityQuery extends PriorityId implements Query
{
}
