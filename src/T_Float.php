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
     * Validated coercion over an UNTYPED source: use the value only when it is
     * genuinely numeric, else the default. Unlike {@see self::coalesce()} (which
     * blind-casts), this GUARDS the type and never masks non-numeric input.
     */
    public static function coerce(mixed $value, float $default = self::ZERO): float
    {
        return is_numeric($value) ? (float) $value : $default;
    }

    /**
     * As {@see self::coerce()}, but null when the value is not numeric.
     */
    public static function coerceOrNull(mixed $value): float|null
    {
        return is_numeric($value) ? (float) $value : null;
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
