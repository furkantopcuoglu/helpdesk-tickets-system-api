<?php

namespace User\Application\Queries\User\Find;

use Common\Domain\Bus\Query\Query;
use User\Domain\ValueObjects\UserId;

class FindUserQuery extends UserId implements Query
{
}
