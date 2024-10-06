<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderType extends Enum
{
    const DINE_IN = 'DINE_IN';
    const TAKE_AWAY = 'TAKE_AWAY';
}
