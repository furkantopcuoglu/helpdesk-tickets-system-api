<?php

namespace Common\Domain\Message;

use User\Domain\Entity\User;
use Common\Domain\Bus\AsyncMessage;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class SendEmailQueueMessage extends TraceableDataTransferObject implements AsyncMessage
{
    public User $user;
    public string $to;
    public string $subject;
    public string $content;
}
