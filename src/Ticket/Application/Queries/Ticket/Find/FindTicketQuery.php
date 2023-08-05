<?php

namespace Ticket\Application\Queries\Ticket\Find;

use Common\Domain\Bus\Query\Query;
use Ticket\Domain\ValueObjects\TicketId;

class FindTicketQuery extends TicketId implements Query
{
}
