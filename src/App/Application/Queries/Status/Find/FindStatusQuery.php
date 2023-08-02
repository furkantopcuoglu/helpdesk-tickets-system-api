<?php

namespace App\Application\Queries\Status\Find;

use Common\Domain\Bus\Query\Query;
use App\Domain\ValueObjects\StatusId;

class FindStatusQuery extends StatusId implements Query
{
}
