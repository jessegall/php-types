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

    /**
     * The float zero, as a value.
     *
     * @phpstan-return 0.0
     */
    public static function zero(): float
    {
        return self::ZERO;
    }

    /**
     * The value as a float, or the given default when null — the named home for
     * `(float) ($x ?? 0.0)` and `(float) ($x ?? $fallback)`. Defaults to zero,
     * so `coalesce($x)` reads `(float) ($x ?? 0.0)`.
     */
    public static function coalesce(mixed $value, float $default = self::ZERO): float
    {
        return (float) ($value ?? $default);
    }

    /**
     * Whether the float is exactly zero.
     *
     * Exact comparison against `0.0` — this is literal replacement, not an
     * epsilon tolerance check.
     *
     * @phpstan-assert-if-true 0.0 $value
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
