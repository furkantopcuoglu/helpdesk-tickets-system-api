<?php

namespace Common\Domain\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command);
}
