<?php

namespace User\Application\Commands\User\Recovery;

use User\Domain\Entity\User;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class RecoveryUserCommand extends TraceableDataTransferObject
{
    public User $user;
}
