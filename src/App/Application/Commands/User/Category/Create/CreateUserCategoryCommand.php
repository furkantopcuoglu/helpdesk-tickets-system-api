<?php

namespace App\Application\Commands\User\Category\Create;

use User\Domain\Entity\User;
use App\Domain\Entity\Category;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateUserCategoryCommand extends TraceableDataTransferObject
{
    public Category $category;
    public User $user;
}
