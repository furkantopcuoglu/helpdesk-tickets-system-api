<?php

namespace App\Application\Commands\User\Category\Delete;

use App\Domain\Entity\UserCategory;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteUserCategoryCommand extends TraceableDataTransferObject
{
    public UserCategory $userCategory;
}
