<?php

namespace Common\Application\Commands\Media\Create;

use User\Domain\Entity\User;
use Common\Domain\Bus\Command\Command;
use Common\Domain\DataTransferObject\TraceableDataTransferObject;

class CreateMediaCommand extends TraceableDataTransferObject implements Command
{
    public string $name;
    public string $path;
    public string $module;
    public string $url;
    public ?User $user;
}
