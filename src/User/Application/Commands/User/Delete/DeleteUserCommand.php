<?php

namespace User\Application\Commands\User\Delete;

use User\Domain\Entity\User;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class DeleteUserCommand extends TraceableDataTransferObject
{
    public User $user;
    public User $deletedBy;
}
