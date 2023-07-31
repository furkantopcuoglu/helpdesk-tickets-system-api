<?php

namespace App\Application\Commands\Category\Update;

use App\Domain\Entity\Category;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdateCategoryCommand extends TraceableDataTransferObject
{
    public Category $category;
    public ?string $name;
    public ?string $color;
}
