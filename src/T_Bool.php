<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * Named home for the boolean literals — `true` and `false` as predicates.
 */
final class T_Bool
{

    /**
     * Boolean true.
     */
    public const TRUE = true;

    /**
     * Boolean false.
     */
    public const FALSE = false;

    /**
     * The value as a bool, or the given default when null — the named home for
     * `(bool) ($x ?? false)` and `(bool) ($x ?? $fallback)`. Defaults to false,
     * so `coalesce($x)` reads `(bool) ($x ?? false)`.
     */
    public static function coalesce(mixed $value, bool $default = self::FALSE): bool
    {
        return (bool) ($value ?? $default);
    }

    /**
     * Validated coercion over an UNTYPED source: use the value only when it is
     * genuinely boolean-ish (a real bool, or `1`/`0`/`"true"`/`"false"`/`"yes"`/
     * `"no"`/`"on"`/`"off"`), else the default. Unlike {@see self::coalesce()}
     * (which blind-casts — `coalesce("abc")` is `true`), this GUARDS the type.
     */
    public static function coerce(mixed $value, bool $default = self::FALSE): bool
    {
        $coerced = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        return $coerced ?? $default;
    }

    /**
     * As {@see self::coerce()}, but null when the value is not boolean-ish.
     */
    public static function coerceOrNull(mixed $value): bool|null
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * Whether the value is true.
     *
     * @phpstan-assert-if-true true $value
     * @phpstan-assert-if-false false $value
     */
    public static function isTrue(bool $value): bool
    {
        return $value === self::TRUE;
    }

    /**
     * Whether the value is false.
     *
     * @phpstan-assert-if-true false $value
     * @phpstan-assert-if-false true $value
     */
    public static function isFalse(bool $value): bool
    {
        return $value === self::FALSE;
    }

}
