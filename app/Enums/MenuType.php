<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class MenuType extends Enum
{
    const APPETIZER = 'APPETIZER';
    const MAIN_COURSE = 'MAIN_COURSE';
    const DESSERTS = 'DESSERTS';
    const DRINKS = 'DRINKS';

    public static function toSelectOption()
    {
        return array_map(function($value, $key) {
            return ['id' => $key, 'value' => $value];
        }, self::toSelectArray(), self::getKeys());
    }
}
