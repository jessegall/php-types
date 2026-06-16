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
     * The integer one.
     */
    public const ONE = 1;

    /**
     * Negative one — the usual "not found" / comparator sentinel.
     */
    public const MINUS_ONE = -1;

    /**
     * The integer zero, as a value.
     *
     * @phpstan-return 0
     */
    public static function zero(): int
    {
        return self::ZERO;
    }

    /**
     * The value as an int, or the given default when null — the named home for
     * `(int) ($x ?? 0)` and `(int) ($x ?? $fallback)`. Defaults to zero, so
     * `coalesce($x)` reads `(int) ($x ?? 0)`.
     */
    public static function coalesce(mixed $value, int $default = self::ZERO): int
    {
        return (int) ($value ?? $default);
    }

    /**
     * Whether the integer is zero.
     *
     * @phpstan-assert-if-true 0 $value
     * @phpstan-assert-if-false int<min, -1>|int<1, max> $value
     */
    public static function isZero(int $value): bool
    {
        return $value === self::ZERO;
    }

    /**
     * Whether the integer is anything but zero.
     *
     * @phpstan-assert-if-true int<min, -1>|int<1, max> $value
     * @phpstan-assert-if-false 0 $value
     */
    public static function isNotZero(int $value): bool
    {
        return ! self::isZero($value);
    }

}
