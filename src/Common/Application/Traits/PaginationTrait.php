<?php

namespace Common\Application\Traits;

trait PaginationTrait
{
    public ?int $page = 1;
    public ?int $perPage = 50;
}
