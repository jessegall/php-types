<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * Named home for the integer zero — `0` with a name and a predicate.
 */
final class T_Int
{

    /**
     * The integer zero.
     */
    public const ZERO = 0;

    /**
     * The integer zero, as a value.
     */
    public static function zero(): int
    {
        return self::ZERO;
    }

    /**
     * Whether the integer is zero.
     */
    public static function isZero(int $value): bool
    {
        return $value === self::ZERO;
    }

    /**
     * Whether the integer is anything but zero.
     */
    public static function isNotZero(int $value): bool
    {
        return ! self::isZero($value);
    }

}
