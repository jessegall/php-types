<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\Option;
use JesseGall\PhpTypes\Tests\TestCase;
use JesseGall\PhpTypes\UnwrapException;

class OptionTest extends TestCase
{
    // ── Construction & querying ─────────────────────────────────────────

    public function test_some_is_present(): void
    {
        $option = Option::some(5);

        $this->assertTrue($option->isSome());
        $this->assertFalse($option->isNone());
    }

    public function test_none_is_absent(): void
    {
        $option = Option::none();

        $this->assertTrue($option->isNone());
        $this->assertFalse($option->isSome());
    }

    public function test_some_can_hold_null(): void
    {
        $option = Option::some(null);

        $this->assertTrue($option->isSome(), 'some(null) is still present — distinct from none');
        $this->assertNull($option->unwrap());
    }

    public function test_from_nullable_maps_null_to_none(): void
    {
        $this->assertTrue(Option::fromNullable(null)->isNone());
        $this->assertTrue(Option::fromNullable(0)->isSome());
        $this->assertSame('x', Option::fromNullable('x')->unwrap());
    }

    public function test_is_some_and(): void
    {
        $this->assertTrue(Option::some(4)->isSomeAnd(fn (int $n) => $n % 2 === 0));
        $this->assertFalse(Option::some(3)->isSomeAnd(fn (int $n) => $n % 2 === 0));
        $this->assertFalse(Option::none()->isSomeAnd(fn () => true));
    }

    public function test_is_none_or(): void
    {
        $this->assertTrue(Option::none()->isNoneOr(fn () => false));
        $this->assertTrue(Option::some(4)->isNoneOr(fn (int $n) => $n % 2 === 0));
        $this->assertFalse(Option::some(3)->isNoneOr(fn (int $n) => $n % 2 === 0));
    }

    // ── Extracting ──────────────────────────────────────────────────────

    public function test_unwrap_returns_the_value(): void
    {
        $this->assertSame(5, Option::some(5)->unwrap());
    }

    public function test_unwrap_throws_on_none(): void
    {
        $this->expectException(UnwrapException::class);
        $this->expectExceptionMessage('Called unwrap() on a None value.');

        Option::none()->unwrap();
    }

    public function test_expect_uses_the_given_message(): void
    {
        $this->expectException(UnwrapException::class);
        $this->expectExceptionMessage('user must exist');

        Option::none()->expect('user must exist');
    }

    public function test_expect_returns_the_value_when_present(): void
    {
        $this->assertSame(5, Option::some(5)->expect('present'));
    }

    public function test_unwrap_or(): void
    {
        $this->assertSame(5, Option::some(5)->unwrapOr(0));
        $this->assertSame(0, Option::none()->unwrapOr(0));
    }

    public function test_unwrap_or_else_is_lazy(): void
    {
        $called = false;

        $this->assertSame(5, Option::some(5)->unwrapOrElse(function () use (&$called) {
            $called = true;

            return 0;
        }));
        $this->assertFalse($called, 'the default callback is not run when present');

        $this->assertSame(9, Option::none()->unwrapOrElse(fn () => 9));
    }

    public function test_to_nullable(): void
    {
        $this->assertSame(5, Option::some(5)->toNullable());
        $this->assertNull(Option::none()->toNullable());
    }

    // ── Transforming ────────────────────────────────────────────────────

    public function test_map_transforms_some(): void
    {
        $this->assertSame(10, Option::some(5)->map(fn (int $n) => $n * 2)->unwrap());
    }

    public function test_map_leaves_none_untouched(): void
    {
        $mapped = Option::none()->map(fn (int $n) => $n * 2);

        $this->assertTrue($mapped->isNone());
    }

    public function test_map_or(): void
    {
        $this->assertSame(10, Option::some(5)->mapOr(-1, fn (int $n) => $n * 2));
        $this->assertSame(-1, Option::none()->mapOr(-1, fn (int $n) => $n * 2));
    }

    public function test_map_or_else(): void
    {
        $this->assertSame(10, Option::some(5)->mapOrElse(fn () => -1, fn (int $n) => $n * 2));
        $this->assertSame(-1, Option::none()->mapOrElse(fn () => -1, fn (int $n) => $n * 2));
    }

    public function test_inspect_runs_only_when_present_and_returns_self(): void
    {
        $seen = [];
        $option = Option::some(5);

        $this->assertSame($option, $option->inspect(function (int $n) use (&$seen) {
            $seen[] = $n;
        }));

        Option::none()->inspect(function (int $n) use (&$seen) {
            $seen[] = $n;
        });

        $this->assertSame([5], $seen);
    }

    public function test_filter(): void
    {
        $this->assertTrue(Option::some(4)->filter(fn (int $n) => $n % 2 === 0)->isSome());
        $this->assertTrue(Option::some(3)->filter(fn (int $n) => $n % 2 === 0)->isNone());
        $this->assertTrue(Option::none()->filter(fn () => true)->isNone());
    }

    // ── Combining ───────────────────────────────────────────────────────

    public function test_and(): void
    {
        $this->assertSame(2, Option::some(1)->and(Option::some(2))->unwrap());
        $this->assertTrue(Option::none()->and(Option::some(2))->isNone());
    }

    public function test_and_then_chains_and_short_circuits(): void
    {
        $half = fn (int $n) => $n % 2 === 0 ? Option::some($n / 2) : Option::none();

        $this->assertSame(2, Option::some(4)->andThen($half)->unwrap());
        $this->assertTrue(Option::some(3)->andThen($half)->isNone());
        $this->assertTrue(Option::none()->andThen($half)->isNone());
    }

    public function test_or(): void
    {
        $this->assertSame(1, Option::some(1)->or(Option::some(2))->unwrap());
        $this->assertSame(2, Option::none()->or(Option::some(2))->unwrap());
    }

    public function test_or_else_is_lazy(): void
    {
        $this->assertSame(1, Option::some(1)->orElse(fn () => Option::some(2))->unwrap());
        $this->assertSame(2, Option::none()->orElse(fn () => Option::some(2))->unwrap());
    }

    public function test_or_falls_back_to_a_differently_typed_option(): void
    {
        // arrange
        $present = Option::some('kept');
        $empty = Option::none();

        // act / assert — the alternative may carry a different T (covariant union)
        $this->assertSame('kept', $present->or(Option::some(42))->unwrap());
        $this->assertSame(42, $empty->or(Option::some(42))->unwrap());
        $this->assertSame(42, $empty->orElse(fn () => Option::some(42))->unwrap());
    }

    public function test_xor(): void
    {
        $this->assertSame(1, Option::some(1)->xor(Option::none())->unwrap());
        $this->assertSame(2, Option::none()->xor(Option::some(2))->unwrap());
        $this->assertTrue(Option::some(1)->xor(Option::some(2))->isNone());
        $this->assertTrue(Option::none()->xor(Option::none())->isNone());
    }

    public function test_zip(): void
    {
        $this->assertSame([1, 'a'], Option::some(1)->zip(Option::some('a'))->unwrap());
        $this->assertTrue(Option::some(1)->zip(Option::none())->isNone());
        $this->assertTrue(Option::none()->zip(Option::some('a'))->isNone());
    }

    public function test_flatten(): void
    {
        $this->assertSame(5, Option::some(Option::some(5))->flatten()->unwrap());
        $this->assertTrue(Option::some(Option::none())->flatten()->isNone());
        $this->assertTrue(Option::none()->flatten()->isNone());
        $this->assertSame(5, Option::some(5)->flatten()->unwrap(), 'a non-nested some flattens to itself');
    }

    // ── Equality & iteration ────────────────────────────────────────────

    public function test_equals(): void
    {
        $this->assertTrue(Option::some(5)->equals(Option::some(5)));
        $this->assertFalse(Option::some(5)->equals(Option::some(6)));
        $this->assertTrue(Option::none()->equals(Option::none()));
        $this->assertFalse(Option::some(5)->equals(Option::none()));
    }

    public function test_iterates_one_value_when_present(): void
    {
        $this->assertSame([5], iterator_to_array(Option::some(5)));
    }

    public function test_iterates_nothing_when_empty(): void
    {
        $this->assertSame([], iterator_to_array(Option::none()));
    }
}
