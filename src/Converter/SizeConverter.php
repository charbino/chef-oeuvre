<?php

/*
 * This file is part of the EMS package.
 *
 * (c) NewQuest Entertainment
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Converter;

class SizeConverter
{
    public static function inchToCentimeter(int $feet = 0, int $inches = 0): int
    {
        return (int) round((($feet * 12) + $inches) * 2.54, 0);
    }

    public static function poundToKilo(float $pounds): float
    {
        return round($pounds * 0.45359237 * 100) / 100;
    }
}