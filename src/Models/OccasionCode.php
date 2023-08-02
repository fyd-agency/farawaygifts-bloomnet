<?php

namespace BloomNetwork\Models;

use Spatie\Enum\Enum;

/**
 * @method static self Funeral_Memorial()
 * @method static self Illness()
 * @method static self Birthday()
 * @method static self Business()
 * @method static self Holiday()
 * @method static self Maternity()
 * @method static self Anniversary()
 * @method static self Others
 */
class OccasionCode extends Enum
{
    protected static function values(): array
    {
        return [
            'Funeral_Memorial' => 1,
            'Illness' => 2,
            'Birthday' => 3,
            'Business' => 4,
            'Holiday' => 5,
            'Maternity' => 6,
            'Anniversary' => 7,
            'Others' => 8,
        ];
    }
}
