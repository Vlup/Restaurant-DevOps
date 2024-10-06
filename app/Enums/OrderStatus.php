<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatus extends Enum
{
    const PENDING = 'PENDING';
    const ON_GOING = 'ON_GOING';
    const COMPLETED = 'COMPLETED';
    const DECLINED = 'DECLINED';
}
