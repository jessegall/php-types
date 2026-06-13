<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * Named home for the empty array — `[]` with a name and a predicate.
 */
final class T_Array
{

    /**
     * The empty array.
     *
     * @var array<never, never>
     */
    public const EMPTY = [];

    /**
     * A two-dimensional (nested) array seeded with one empty inner array —
     * the `[[]]` literal, e.g. a stack of frames started with a single empty
     * frame. Distinct from EMPTY (`[]`): this already holds one inner array.
     *
     * @var array<int, array<array-key, mixed>>
     */
    public const MATRIX = [[]];

    /**
     * The empty array, as a value.
     *
     * @return array<never, never>
     */
    public static function empty(): array
    {
        return self::EMPTY;
    }

    /**
     * A two-dimensional (nested) array seeded with one empty inner array, as
     * a value — the `[[]]` literal.
     *
     * @return array<int, array<array-key, mixed>>
     */
    public static function matrix(): array
    {
        return self::MATRIX;
    }

    /**
     * Whether the array holds no elements.
     *
     * @param  array<array-key, mixed>  $value
     */
    public static function isEmpty(array $value): bool
    {
        return $value === self::EMPTY;
    }

    /**
     * Whether the array holds any elements.
     *
     * @param  array<array-key, mixed>  $value
     */
    public static function isNotEmpty(array $value): bool
    {
        return ! self::isEmpty($value);
    }

}
