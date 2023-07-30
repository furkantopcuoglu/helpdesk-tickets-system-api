<?php

namespace User\Application\Commands\User\Banned;

use User\Domain\Entity\User;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class BannedUserCommand extends TraceableDataTransferObject
{
    public User $user;
}
