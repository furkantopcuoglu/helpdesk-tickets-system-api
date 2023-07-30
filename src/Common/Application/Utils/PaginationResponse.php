<?php

namespace Common\Application\Utils;

use Common\Domain\DataTransferObject\DataTransferObject;

class PaginationResponse extends DataTransferObject
{
    public array $results;
    public int $page;
    public int $perPage;
    public int $totalPage;
    public int $total;
}
