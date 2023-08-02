<?php

namespace App\Application\Commands\User\Category\Delete;

use App\Domain\Entity\UserCategory;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteUserCategoryCommand extends TraceableDataTransferObject implements Command
{
    public UserCategory $userCategory;
}
