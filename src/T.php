<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

/**
 * A PHP type as a first-class, type-safe token — so an allow-list reads
 * `[T::Array, T::String]` instead of the magic strings `['array', 'string']`.
 *
 * Each case knows how to test a value ({@see matches()}), so it doubles as a
 * predicate. Handy wherever a set of permitted types is declared — e.g. a
 * union/sum-type cast: `#[WithCast(UnionCast::class, allowed: [T::Array, T::String])]`.
 */
enum T: string
{
    case String = 'string';

    case Int = 'int';

    case Float = 'float';

    case Bool = 'bool';

    case Array = 'array';

    case Object = 'object';

    case Callable = 'callable';

    case Iterable = 'iterable';

    case Null = 'null';

    /**
     * Whether the value is of this type.
     */
    public function matches(mixed $value): bool
    {
        return match ($this) {
            self::String => is_string($value),
            self::Int => is_int($value),
            self::Float => is_float($value),
            self::Bool => is_bool($value),
            self::Array => is_array($value),
            self::Object => is_object($value),
            self::Callable => is_callable($value),
            self::Iterable => is_iterable($value),
            self::Null => $value === null,
        };
    }

    /**
     * Whether the value matches ANY of the given types — the allow-list check.
     */
    public static function any(mixed $value, self ...$types): bool
    {
        foreach ($types as $type) {
            if ($type->matches($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * The runtime type of the value as a token, or null for a type with no case
     * here (e.g. a resource). Declaration order resolves to the concrete type:
     * a callable string is {@see String}, an iterable array is {@see Array}.
     */
    public static function of(mixed $value): ?self
    {
        foreach (self::cases() as $type) {
            if ($type->matches($value)) {
                return $type;
            }
        }

        return null;
    }
}
