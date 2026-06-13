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
