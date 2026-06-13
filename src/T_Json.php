<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

use stdClass;

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
     * Whether the string decodes to an empty JSON object.
     *
     * Semantic, not textual — `'{}'`, `'{ }'`, and `"{\n}"` are all empty
     * objects. Non-objects (`'[]'`) and invalid JSON are not.
     */
    public static function isEmptyObject(string $json): bool
    {
        $decoded = json_decode($json);

        return $decoded instanceof stdClass && (array) $decoded === [];
    }

    /**
     * Whether the string decodes to an empty JSON array.
     *
     * Semantic, not textual — `'[]'`, `'[ ]'`, and `"[\n]"` are all empty
     * arrays. Non-arrays (`'{}'`) and invalid JSON are not.
     */
    public static function isEmptyArray(string $json): bool
    {
        return json_decode($json) === [];
    }

}
