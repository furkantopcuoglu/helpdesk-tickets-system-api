<?php

namespace User\Application\Commands\User\Recovery;

use User\Domain\Entity\User;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class RecoveryUserCommand extends TraceableDataTransferObject implements Command
{
    public User $user;
}
