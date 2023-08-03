<?php

namespace App\Application\Enum;

use Common\Application\Traits\EnumToArrayTrait;

enum StatusType: string
{
    use EnumToArrayTrait;

    case NEW = 'New';
    case PENDING = 'Pending';
    case WAITING = 'Waiting';
    case RESOLVED = 'Resolved';
    case CLOSED = 'Closed';
    case REJECTED = 'Rejected';

    public static function getColor(StatusType $statusType): string
    {
        return match ($statusType) {
            self::NEW => '#5ba8ff',
            self::PENDING => '#F7CB73',
            self::WAITING => '#9d9d9d',
            self::RESOLVED => '#149609',
            self::CLOSED => '#25252c',
            self::REJECTED => '#ff5ba8',
        };
    }
}
