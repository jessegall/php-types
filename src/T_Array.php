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
     * An empty two-dimensional (nested) array — a matrix. The value is the
     * same empty array; the type says each element is itself an array, so a
     * `$grid = T_Array::MATRIX` initializer is correctly typed for analysis.
     *
     * @var array<array-key, array<array-key, mixed>>
     */
    public const MATRIX = [];

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
     * An empty two-dimensional (nested) array, as a value.
     *
     * @return array<array-key, array<array-key, mixed>>
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
