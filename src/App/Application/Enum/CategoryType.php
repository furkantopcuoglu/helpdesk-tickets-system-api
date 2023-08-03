<?php

namespace App\Application\Enum;

use Common\Application\Traits\EnumToArrayTrait;

enum CategoryType: string
{
    use EnumToArrayTrait;

    case PROBLEM = 'Problem';
    case BILLING = 'Billing';
    case REQUEST = 'Request';
    case ACCOUNT = 'Account';
    case FEEDBACK = 'Feedback';
    case TECHNICAL_SUPPORT = 'Technical Support';

    public static function getColor(CategoryType $categoryType): string
    {
        return match ($categoryType) {
            self::PROBLEM => '#3366FF',
            self::REQUEST => '#33FFA8',
            self::BILLING => '#FFCA33',
            self::ACCOUNT => '#33FF9A',
            self::FEEDBACK => '#33FFD4',
            self::TECHNICAL_SUPPORT => '#FF33C8',
        };
    }
}
