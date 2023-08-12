<?php

namespace Ticket\Application\Queries\Ticket\FindOneBy;

use User\Domain\Entity\User;
use Common\Domain\Bus\Query\Query;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class FindOneByTicketQuery extends TraceableDataTransferObject implements Query
{
    public ?string $id;
    public ?User $support;
    public ?bool $isAssigment;
}
