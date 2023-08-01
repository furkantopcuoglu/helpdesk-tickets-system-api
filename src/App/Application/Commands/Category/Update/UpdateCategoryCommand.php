<?php

namespace App\Application\Commands\Category\Update;

use App\Domain\Entity\Category;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class UpdateCategoryCommand extends TraceableDataTransferObject implements Command
{
    public Category $category;
    public ?string $name;
    public ?string $color;
}
