<?php

namespace App\Application\Queries\User\Category\FindOneBy;

use User\Domain\Entity\User;
use App\Domain\Entity\Category;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByUserCategoryQuery extends TraceableDataTransferObject
{
    public ?string $id;
    public ?User $user;
    public ?Category $category;
}
