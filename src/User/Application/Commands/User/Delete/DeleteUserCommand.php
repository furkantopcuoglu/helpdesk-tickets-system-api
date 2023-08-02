<?php

namespace User\Application\Commands\User\Delete;

use User\Domain\Entity\User;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteUserCommand extends TraceableDataTransferObject implements Command
{
    public User $user;
    public User $deletedBy;
}
