<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * Named home for the empty JSON literals — `'{}'` and `'[]'`.
 */
final class T_Json
{

    /**
     * The empty JSON object literal.
     */
    public const EMPTY_OBJECT = '{}';

    /**
     * The empty JSON array literal.
     */
    public const EMPTY_ARRAY = '[]';

    private function __construct() {}

    /**
     * The empty JSON object literal, as a value.
     */
    public static function emptyObject(): string
    {
        return self::EMPTY_OBJECT;
    }

    /**
     * The empty JSON array literal, as a value.
     */
    public static function emptyArray(): string
    {
        return self::EMPTY_ARRAY;
    }

    /**
     * Whether the string is exactly the empty JSON object literal.
     *
     * Exact comparison — `'{ }'` and `"{}\n"` are NOT considered empty.
     */
    public static function isEmptyObject(string $json): bool
    {
        return $json === self::EMPTY_OBJECT;
    }

    /**
     * Whether the string is exactly the empty JSON array literal.
     *
     * Exact comparison — `'[ ]'` and `"[]\n"` are NOT considered empty.
     */
    public static function isEmptyArray(string $json): bool
    {
        return $json === self::EMPTY_ARRAY;
    }

}
