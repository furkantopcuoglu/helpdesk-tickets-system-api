<?php

namespace Ticket\Application\Queries\Ticket\Search;

use Common\Domain\Bus\Query\Query;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class SearchTicketQuery extends TraceableDataTransferObject implements Query
{
    public ?string $ticketNo;
    public ?string $subject;
    public ?string $content;
    public ?string $categoryId;
    public ?string $priorityId;
    public ?string $statusId;
    public ?string $userId;
    public ?string $supportId;
    public ?bool $isAssigment;
    public int $page = 1;
    public int $perPage = 50;
}
