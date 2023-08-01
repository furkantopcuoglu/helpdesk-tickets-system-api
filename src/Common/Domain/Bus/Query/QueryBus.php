<?php

namespace Common\Domain\Bus\Query;

interface QueryBus
{
    public function handle(Query $message);
}
