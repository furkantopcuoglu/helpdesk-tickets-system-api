<?php

namespace User\Application\Queries\User\FindByEmail;

use Common\Domain\Bus\Query\Query;
use User\Domain\ValueObjects\UserEmail;

readonly class FindUserByEmailQuery extends UserEmail implements Query
{
}
