<?php

namespace App\Enums;

trait EnumHelper
{
    /**
     * @return array
     */
    public static function values(): array
    {
        $cases = self::cases();

        $values = array_column($cases, 'value');

        return $values;
    }

    /**
     * @param string $delimeter
     * @return string
     */
    public static function valuesImploded(string $delimeter = ','): string
    {
        $values = self::values();

        $imploded = implode($delimeter, $values);

        return $imploded;
    }
}
