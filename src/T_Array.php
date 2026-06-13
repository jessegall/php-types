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
     * Typed as the empty-array shape `array{}` so it is a drop-in for a bare
     * `[]`: assignable to both `list<T>` and `array<K, V>`, exactly like the
     * literal. (`array<never, never>` would not satisfy a `list<T>` contract.)
     *
     * @var array{}
     */
    public const EMPTY = [];

    /**
     * A two-dimensional (nested) array seeded with one empty inner array —
     * the `[[]]` literal, e.g. a stack of frames started with a single empty
     * frame. Distinct from EMPTY (`[]`): this already holds one inner array.
     *
     * Typed as the `array{array{}}` shape so it stays assignable to both
     * `list<array<K, V>>` and `array<int, array<K, V>>`.
     *
     * @var array{array{}}
     */
    public const MATRIX = [[]];

    /**
     * The empty array, as a value.
     *
     * @return array{}
     */
    public static function empty(): array
    {
        return self::EMPTY;
    }

    /**
     * A two-dimensional (nested) array seeded with one empty inner array, as
     * a value — the `[[]]` literal.
     *
     * @return array{array{}}
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
