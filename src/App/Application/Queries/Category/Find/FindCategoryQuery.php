<?php

namespace App\Application\Queries\Category\Find;

use Common\Domain\Bus\Query\Query;
use App\Domain\ValueObjects\CategoryId;

class FindCategoryQuery extends CategoryId implements Query
{
}
