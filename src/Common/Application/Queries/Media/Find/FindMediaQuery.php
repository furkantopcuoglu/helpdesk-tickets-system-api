<?php

namespace Common\Application\Queries\Media\Find;

use Common\Domain\Bus\Query\Query;
use Common\Domain\ValueObjects\MediaId;

class FindMediaQuery extends MediaId implements Query
{
}
