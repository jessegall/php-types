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

    /**
     * A single space.
     */
    public const SPACE = ' ';

    /**
     * The empty string, as a value.
     */
    public static function empty(): string
    {
        return self::EMPTY;
    }

    /**
     * Whether the string is empty.
     *
     * @phpstan-assert-if-true '' $value
     * @phpstan-assert-if-false non-empty-string $value
     */
    public static function isEmpty(string $value): bool
    {
        return $value === self::EMPTY;
    }

    /**
     * Whether the string holds any characters.
     *
     * @phpstan-assert-if-true non-empty-string $value
     * @phpstan-assert-if-false '' $value
     */
    public static function isNotEmpty(string $value): bool
    {
        return ! self::isEmpty($value);
    }

    /**
     * Whether the string is empty or holds only whitespace.
     *
     * This is the named home for the `trim($x) === ''` idiom — the decision
     * that whitespace counts as empty lives here, in the open.
     *
     * @phpstan-assert-if-false non-empty-string $value
     */
    public static function isBlank(string $value): bool
    {
        return trim($value) === self::EMPTY;
    }

    /**
     * Whether the string holds at least one non-whitespace character.
     *
     * @phpstan-assert-if-true non-empty-string $value
     */
    public static function isNotBlank(string $value): bool
    {
        return ! self::isBlank($value);
    }

}
