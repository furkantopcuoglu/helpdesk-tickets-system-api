<?php

namespace User\Application\Commands\User\Banned;

use User\Domain\Entity\User;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class BannedUserCommand extends TraceableDataTransferObject implements Command
{
    public User $user;
}
