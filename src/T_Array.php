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
     * The value, or the given default when null — the named home for `$x ?? []`
     * and `$x ?? $fallback`. Unlike the scalar coalesces this does NOT cast (a
     * `(array)` cast would wrap a non-array value); pass an array or null. The
     * default is the empty array, so `coalesce($x)` reads `$x ?? []`.
     *
     * @param  array<mixed>|null  $value
     * @param  array<mixed>  $default
     * @phpstan-return array<mixed>
     */
    public static function coalesce(?array $value, array $default = self::EMPTY): array
    {
        return $value ?? $default;
    }

    /**
     * The array at `$array[$key]`, or the given default when that key is absent
     * or null — the named home for `$array[$key] ?? []`. Use this for a dynamic
     * dictionary lookup instead of double-coalescing `coalesce($array[$key] ??
     * null)` (the inner `?? null` defeats the point of `coalesce`). The default
     * is the empty array, so `coalesceFor($array, $key)` reads `$array[$key] ??
     * []`.
     *
     * @param  array<array-key, array<mixed>|null>  $array
     * @param  array-key  $key
     * @param  array<mixed>  $default
     * @phpstan-return array<mixed>
     */
    public static function coalesceFor(array $array, int|string $key, array $default = self::EMPTY): array
    {
        return $array[$key] ?? $default;
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
     * Start a fluent {@see ArrayBuilder} seeded with the always-present keys —
     * the named home for assembling an array whose shape is partly conditional,
     * instead of spreading ternaries with empty-array arms or indexing a bag:
     *
     *     T_Array::from(['name' => $x])
     *         ->putUnlessNull('label', $label)
     *         ->putUnlessEmpty('options', $options)
     *         ->toArray();
     *
     * @param  array<array-key, mixed>  $items
     * @return ArrayBuilder<array-key, mixed>
     */
    public static function from(array $items = self::EMPTY): ArrayBuilder
    {
        return ArrayBuilder::from($items);
    }

    /**
     * Re-key an array or iterable to a sequential `list<T>` — the named home for
     * `array_values(...)`, and the clean terminal for a collection chain whose
     * `@return` is a `list<T>`.
     *
     * Larastan types `collect($x)->map(...)->values()->all()` as `array<int, T>`
     * (NOT `list<T>`), which trips a `list<T>` return contract — and
     * `array_values(...)` is the only spelling PHPStan special-cases back to
     * `list<T>`. `T_Array::toList(collect($x)->map(...))` carries that special-case
     * with a name, so the chain reads without a procedural `array_values(...)`
     * wrapped around it. Accepts any iterable (array, Generator, Laravel
     * Collection, …); keys are discarded.
     *
     * @template T
     *
     * @param  iterable<T>  $items
     *
     * @return list<T>
     */
    public static function toList(iterable $items): array
    {
        return array_values(is_array($items) ? $items : iterator_to_array($items, false));
    }

    /**
     * Whether the array holds no elements.
     *
     * @param  array<array-key, mixed>  $value
     *
     * @phpstan-assert-if-false non-empty-array<array-key, mixed> $value
     */
    public static function isEmpty(array $value): bool
    {
        return $value === self::EMPTY;
    }

    /**
     * Whether the array holds any elements.
     *
     * @param  array<array-key, mixed>  $value
     *
     * @phpstan-assert-if-true non-empty-array<array-key, mixed> $value
     */
    public static function isNotEmpty(array $value): bool
    {
        return ! self::isEmpty($value);
    }

}
