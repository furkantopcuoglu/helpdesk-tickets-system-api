<?php

namespace App\Application\Commands\Category\Delete;

use App\Domain\Entity\Category;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteCategoryCommand extends TraceableDataTransferObject implements Command
{
    public Category $category;
}
