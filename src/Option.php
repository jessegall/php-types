<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * A value that is either present (`some`) or absent (`none`). Unlike `?T`, the
 * empty case is part of the type: you reach the value only through a method that
 * confronts absence. Immutable — every transform returns a new Option.
 *
 * @template-covariant T
 *
 * @implements IteratorAggregate<int, T>
 */
final class Option implements IteratorAggregate
{
    /**
     * @param  T  $value  the value when $isSome; an unread placeholder when none
     */
    private function __construct(
        private readonly bool $isSome,
        private readonly mixed $value,
    ) {}

    // ── Construction ────────────────────────────────────────────────────

    /**
     * An Option holding a value.
     *
     * @template TValue
     *
     * @param  TValue  $value
     * @return self<TValue>
     */
    public static function some(mixed $value): self
    {
        return new self(true, $value);
    }

    /**
     * The empty Option.
     *
     * @return self<never>
     */
    public static function none(): self
    {
        /** @var self<never> */
        return new self(false, null);
    }

    /**
     * `null` becomes `none`, anything else `some` — the seam from a `?T` API.
     *
     * @template TValue
     *
     * @param  TValue|null  $value
     * @return self<TValue>
     */
    public static function fromNullable(mixed $value): self
    {
        return $value === null ? self::none() : self::some($value);
    }

    /**
     * A falsy value (`null`, `false`, `0`, `0.0`, `''`, `'0'`, `[]`) becomes `none`, anything
     * truthy `some` — collapses the "absent or blank" guard into one call. Like `fromNullable`,
     * the result type strips `null`, so a `?T` in yields a clean `Option<T>`.
     *
     * @template TValue
     *
     * @param  TValue|null  $value
     * @return self<TValue>
     */
    public static function fromTruthy(mixed $value): self
    {
        return $value ? self::some($value) : self::none();
    }

    // ── Querying ────────────────────────────────────────────────────────

    /**
     * Whether the Option holds a value.
     */
    public function isSome(): bool
    {
        return $this->isSome;
    }

    /**
     * Whether the Option is empty.
     */
    public function isNone(): bool
    {
        return ! $this->isSome;
    }

    /**
     * `some` and the value passes the predicate.
     *
     * @param  callable(T): bool  $predicate
     */
    public function isSomeAnd(callable $predicate): bool
    {
        return $this->isSome && $predicate($this->value);
    }

    /**
     * `none`, or the value passes the predicate.
     *
     * @param  callable(T): bool  $predicate
     */
    public function isNoneOr(callable $predicate): bool
    {
        return ! $this->isSome || $predicate($this->value);
    }

    // ── Extracting the value ────────────────────────────────────────────

    /**
     * The value, or throw if empty.
     *
     * @return T
     *
     * @throws UnwrapException when `none`
     */
    public function unwrap(): mixed
    {
        if (! $this->isSome) {
            throw new UnwrapException('Called unwrap() on a None value.');
        }

        return $this->value;
    }

    /**
     * The value, or throw with $message if empty.
     *
     * @return T
     *
     * @throws UnwrapException when `none`
     */
    public function expect(string $message): mixed
    {
        if (! $this->isSome) {
            throw new UnwrapException($message);
        }

        return $this->value;
    }

    /**
     * The value, or $default if empty.
     *
     * @template TDefault
     *
     * @param  TDefault  $default
     * @return T|TDefault
     */
    public function unwrapOr(mixed $default): mixed
    {
        return $this->isSome ? $this->value : $default;
    }

    /**
     * The value, or the callback's result if empty (lazy default).
     *
     * @template TDefault
     *
     * @param  callable(): TDefault  $default
     * @return T|TDefault
     */
    public function unwrapOrElse(callable $default): mixed
    {
        return $this->isSome ? $this->value : $default();
    }

    /**
     * The value, or `null` if empty — the bridge back to a nullable.
     *
     * @return T|null
     */
    public function toNullable(): mixed
    {
        return $this->isSome ? $this->value : null;
    }

    // ── Transforming ────────────────────────────────────────────────────

    /**
     * Map a `some` value through the callback; `none` stays `none`.
     *
     * @template U
     *
     * @param  callable(T): U  $fn
     * @return self<U>
     */
    public function map(callable $fn): self
    {
        return $this->isSome ? self::some($fn($this->value)) : self::none();
    }

    /**
     * Map a `some` value through the callback, or return $default if empty.
     *
     * @template U
     *
     * @param  U  $default
     * @param  callable(T): U  $fn
     * @return U
     */
    public function mapOr(mixed $default, callable $fn): mixed
    {
        return $this->isSome ? $fn($this->value) : $default;
    }

    /**
     * Map a `some` value through $fn, or compute a default via $default if empty.
     *
     * @template U
     *
     * @param  callable(): U  $default
     * @param  callable(T): U  $fn
     * @return U
     */
    public function mapOrElse(callable $default, callable $fn): mixed
    {
        return $this->isSome ? $fn($this->value) : $default();
    }

    /**
     * Run a side effect on the value if present; returns the same Option.
     *
     * @param  callable(T): void  $fn
     * @return self<T>
     */
    public function inspect(callable $fn): self
    {
        if ($this->isSome) {
            $fn($this->value);
        }

        return $this;
    }

    /**
     * Keep a `some` only when its value passes the predicate; else `none`.
     *
     * @param  callable(T): bool  $predicate
     * @return self<T>
     */
    public function filter(callable $predicate): self
    {
        return $this->isSome && $predicate($this->value) ? $this : self::none();
    }

    // ── Combining ───────────────────────────────────────────────────────

    /**
     * $optb if this is `some`, else `none`.
     *
     * @template U
     *
     * @param  self<U>  $optb
     * @return self<U>
     */
    public function and(self $optb): self
    {
        return $this->isSome ? $optb : self::none();
    }

    /**
     * Chain another Option-returning step onto a `some`; short-circuits on `none`.
     *
     * @template U
     *
     * @param  callable(T): self<U>  $fn
     * @return self<U>
     */
    public function andThen(callable $fn): self
    {
        return $this->isSome ? $fn($this->value) : self::none();
    }

    /**
     * This Option if `some`, else $optb.
     *
     * @template TOther
     *
     * @param  self<TOther>  $optb
     * @return self<T>|self<TOther>
     */
    public function or(self $optb): self
    {
        return $this->isSome ? $this : $optb;
    }

    /**
     * This Option if `some`, else the callback's Option (lazy).
     *
     * @template TOther
     *
     * @param  callable(): self<TOther>  $fn
     * @return self<T>|self<TOther>
     */
    public function orElse(callable $fn): self
    {
        return $this->isSome ? $this : $fn();
    }

    /**
     * Exactly one of the two, or `none` if both or neither are `some`.
     *
     * @template TOther
     *
     * @param  self<TOther>  $optb
     * @return self<T>|self<TOther>
     */
    public function xor(self $optb): self
    {
        if ($this->isSome === $optb->isSome) {
            return self::none();
        }

        return $this->isSome ? $this : $optb;
    }

    /**
     * Pair two `some`s into an Option of a tuple; `none` if either is empty.
     *
     * @template U
     *
     * @param  self<U>  $other
     * @return self<array{T, U}>
     */
    public function zip(self $other): self
    {
        return $this->isSome && $other->isSome
            ? self::some([$this->value, $other->value])
            : self::none();
    }

    /**
     * Collapse an `Option<Option<U>>` into an `Option<U>` (one level).
     *
     * @return self<mixed>
     */
    public function flatten(): self
    {
        if (! $this->isSome) {
            return self::none();
        }

        return $this->value instanceof self ? $this->value : $this;
    }

    // ── Equality & iteration ────────────────────────────────────────────

    /**
     * Both empty, or both `some` with `===`-equal values.
     *
     * @param  self<mixed>  $other
     */
    public function equals(self $other): bool
    {
        if ($this->isSome !== $other->isSome) {
            return false;
        }

        return ! $this->isSome || $this->value === $other->value;
    }

    /**
     * Iterate zero (none) or one (some) value, so `foreach` visits a present value.
     *
     * @return Traversable<int, T>
     */
    public function getIterator(): Traversable
    {
        /** @var list<T> $items */
        $items = $this->isSome ? [$this->value] : [];

        return new ArrayIterator($items);
    }
}
