<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes;

use Closure;

/**
 * Deferred defaults — each method returns a zero-argument Closure that produces
 * the named empty/zero value of a type. For when a place wants a CALLABLE that
 * yields the default rather than the value itself: a resolver `->then(...)`
 * factory, a lazy fallback, an `array_map` seed, etc.
 *
 *     $make = Defaults::array();   // Closure(): array{}
 *     $make();                     // []
 *
 *     IsNull::make()->then(Defaults::array());   // instead of fn () => []
 *
 * For the value directly, use the type's own accessor (`T_Array::empty()`,
 * `T_Int::zero()`, …) — this class exists only for the callable form.
 */
final class Defaults
{

    /**
     * A factory for the empty array `[]`.
     *
     * @return Closure(): array{}
     */
    public static function array(): Closure
    {
        return static fn (): array => T_Array::EMPTY;
    }

    /**
     * A factory for the empty string `''`.
     *
     * @return Closure(): ''
     */
    public static function string(): Closure
    {
        return static fn (): string => T_String::EMPTY;
    }

    /**
     * A factory for the integer zero `0`.
     *
     * @return Closure(): 0
     */
    public static function int(): Closure
    {
        return static fn (): int => T_Int::ZERO;
    }

    /**
     * A factory for the float zero `0.0`.
     *
     * @return Closure(): 0.0
     */
    public static function float(): Closure
    {
        return static fn (): float => T_Float::ZERO;
    }

    /**
     * A factory for the default boolean `false` (the falsy default, like `0`).
     *
     * @return Closure(): false
     */
    public static function bool(): Closure
    {
        return static fn (): bool => T_Bool::FALSE;
    }

    /**
     * A factory for `null`.
     *
     * @return Closure(): null
     */
    public static function null(): Closure
    {
        return static fn () => null;
    }

}
