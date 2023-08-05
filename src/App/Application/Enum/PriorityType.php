<?php

namespace App\Application\Enum;

use Common\Application\Traits\EnumToArrayTrait;

enum PriorityType: string
{
    use EnumToArrayTrait;

    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'High';
    case CRITICAL = 'Critical';

    public static function getColor(PriorityType $statusType): string
    {
        return match ($statusType) {
            self::LOW => '#008000',
            self::MEDIUM => '#FFFF00',
            self::HIGH => '#FFA500',
            self::CRITICAL => '#FF0000',
        };
    }

    public static function getEmoji(string $color): string
    {
        return match ($color) {
            '#008000' => '🟢',
            '#FFFF00' => '🟡',
            '#FFA500' => '🟠',
            '#FF0000' => '🔴',
            default => '',
        };
    }
}
