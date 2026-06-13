<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * Named home for the empty string — `''` with a name and a predicate.
 */
final class T_String
{

    /**
     * The empty string.
     */
    public const EMPTY = '';

    private function __construct() {}

    /**
     * The empty string, as a value.
     */
    public static function empty(): string
    {
        return self::EMPTY;
    }

    /**
     * Whether the string is empty.
     */
    public static function isEmpty(string $value): bool
    {
        return $value === self::EMPTY;
    }

    /**
     * Whether the string holds any characters.
     */
    public static function isNotEmpty(string $value): bool
    {
        return ! self::isEmpty($value);
    }

}
