<?php

namespace App\Application\Commands\Category\Delete;

use App\Domain\Entity\Category;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteCategoryCommand extends TraceableDataTransferObject
{
    public Category $category;
}
