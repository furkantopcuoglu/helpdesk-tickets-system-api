<?php

namespace App\Application\Queries\User\Category\List;

use User\Domain\Entity\User;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class ListUserCategoryQuery extends TraceableDataTransferObject
{
    public User $user;
}
