<?php

namespace Common\Application\Enum;

enum TelegramChatterType: string
{
    case NEW_TICKET = 'NEW_TICKET';
    case ASSIGMENT_SUPPORT_TICKET = 'A help desk team has been assigned for the ticket.';
}
