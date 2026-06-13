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
     */
    public static function isTrue(bool $value): bool
    {
        return $value === self::TRUE;
    }

    /**
     * Whether the value is false.
     */
    public static function isFalse(bool $value): bool
    {
        return $value === self::FALSE;
    }

}
