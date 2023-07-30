<?php

namespace Common\Application\Utils;

class FilterParams
{
    public static function nullFilter(array $params): array
    {
        return collect($params)
            ->filter(function ($value) {
                if (!\is_array($value) && !is_bool($value) && '' === trim($value)) {
                    return false;
                }

                return true;
            })
            ->toArray();
    }
}
