<?php

namespace App\Application\Commands\User\Category\Create;

use User\Domain\Entity\User;
use App\Domain\Entity\Category;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateUserCategoryCommand extends TraceableDataTransferObject implements Command
{
    public Category $category;
    public User $user;
}
