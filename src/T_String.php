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

    // ── Invisible whitespace / control characters ──────────────────────

    /**
     * A line feed — `"\n"`.
     */
    public const NEWLINE = "\n";

    /**
     * A blank line / paragraph break — `"\n\n"`.
     */
    public const PARAGRAPH = "\n\n";

    /**
     * A carriage return — `"\r"`.
     */
    public const CARRIAGE_RETURN = "\r";

    /**
     * A Windows line ending — `"\r\n"`.
     */
    public const CRLF = "\r\n";

    /**
     * A horizontal tab — `"\t"`.
     */
    public const TAB = "\t";

    /**
     * A NUL byte — `"\0"`.
     */
    public const NULL_BYTE = "\0";

    // ── Common visible separators ──────────────────────────────────────

    /**
     * A comma — `','`.
     */
    public const COMMA = ',';

    /**
     * A comma followed by a space — `', '`, the usual list join.
     */
    public const COMMA_SPACE = ', ';

    /**
     * A forward slash — `'/'`.
     */
    public const SLASH = '/';

    /**
     * A dot — `'.'`.
     */
    public const DOT = '.';

    /**
     * A dash / hyphen — `'-'`.
     */
    public const DASH = '-';

    /**
     * The empty string, as a value.
     *
     * @phpstan-return ''
     */
    public static function empty(): string
    {
        return self::EMPTY;
    }

    /**
     * The value as a string, or the given default when null — the named home
     * for `(string) ($x ?? '')` and `(string) ($x ?? $fallback)`. The default
     * is the empty string, so `coalesce($x)` reads `(string) ($x ?? '')`.
     */
    public static function coalesce(mixed $value, string $default = self::EMPTY): string
    {
        return (string) ($value ?? $default);
    }

    /**
     * Validated coercion over an UNTYPED source (config, request bags, metadata):
     * use the value only when it is genuinely a non-empty scalar string, else the
     * default. Unlike {@see self::coalesce()} (which blind-casts — `coalesce([])`
     * is `"Array"`), this never casts an array/object; it GUARDS the type.
     */
    public static function coerce(mixed $value, string $default = self::EMPTY): string
    {
        return is_scalar($value) && ($s = (string) $value) !== self::EMPTY ? $s : $default;
    }

    /**
     * As {@see self::coerce()}, but null (not a default) when the value is not a
     * non-empty scalar string.
     */
    public static function coerceOrNull(mixed $value): string|null
    {
        return is_scalar($value) && ($s = (string) $value) !== self::EMPTY ? $s : null;
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
