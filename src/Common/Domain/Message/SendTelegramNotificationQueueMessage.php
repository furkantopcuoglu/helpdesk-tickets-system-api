<?php

namespace Common\Domain\Message;

use Ticket\Domain\Entity\Ticket;
use Common\Domain\Bus\AsyncMessage;
use Common\Application\Enum\TelegramChatterType;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class SendTelegramNotificationQueueMessage extends TraceableDataTransferObject implements AsyncMessage
{
    public Ticket $ticket;
    public TelegramChatterType $telegramChatterType;
}
