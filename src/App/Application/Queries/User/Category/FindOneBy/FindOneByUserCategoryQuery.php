<?php

namespace App\Application\Queries\User\Category\FindOneBy;

use User\Domain\Entity\User;
use App\Domain\Entity\Category;
use Common\Domain\Bus\Query\Query;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByUserCategoryQuery extends TraceableDataTransferObject implements Query
{
    public ?string $id;
    public ?User $user;
    public ?Category $category;
}
