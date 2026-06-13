<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * Named home for the float zero — `0.0` with a name and a predicate.
 */
final class T_Float
{

    /**
     * The float zero.
     */
    public const ZERO = 0.0;

    private function __construct() {}

    /**
     * The float zero, as a value.
     */
    public static function zero(): float
    {
        return self::ZERO;
    }

    /**
     * Whether the float is exactly zero.
     *
     * Exact comparison against `0.0` — this is literal replacement, not an
     * epsilon tolerance check.
     */
    public static function isZero(float $value): bool
    {
        return $value === self::ZERO;
    }

    /**
     * Whether the float is anything but exactly zero.
     */
    public static function isNotZero(float $value): bool
    {
        return ! self::isZero($value);
    }

}
