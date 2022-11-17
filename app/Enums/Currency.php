<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SYR()
 * @method static static USD()
 * @method static static KWD()
 */
final class Currency extends Enum
{
    const SYR = "SYR";
    const USD = "USD";
    const KWD = "KWD";
}
