<?php

declare(strict_types=1);

namespace JesseGall\PhpTypes\Tests\Unit;

use JesseGall\PhpTypes\T;
use JesseGall\PhpTypes\Tests\TestCase;

class TTest extends TestCase
{
    public function test_matches_tests_a_value_against_the_token(): void
    {
        $this->assertTrue(T::String->matches('x'));
        $this->assertTrue(T::Int->matches(1));
        $this->assertTrue(T::Float->matches(1.5));
        $this->assertTrue(T::Bool->matches(true));
        $this->assertTrue(T::Array->matches([]));
        $this->assertTrue(T::Object->matches(new \stdClass));
        $this->assertTrue(T::Null->matches(null));

        $this->assertFalse(T::String->matches(1));
        $this->assertFalse(T::Int->matches('1'));
        $this->assertFalse(T::Array->matches('x'));
    }

    public function test_any_is_the_allow_list_check(): void
    {
        $this->assertTrue(T::any('x', T::Array, T::String));
        $this->assertTrue(T::any([], T::Array, T::String));
        $this->assertFalse(T::any(1, T::Array, T::String));
        $this->assertFalse(T::any('x'));
    }

    public function test_of_returns_the_runtime_token(): void
    {
        $this->assertSame(T::String, T::of('x'));
        $this->assertSame(T::Int, T::of(1));
        $this->assertSame(T::Array, T::of([]));
        $this->assertSame(T::Null, T::of(null));
        $this->assertNull(T::of(fopen('php://memory', 'r')));
    }

    public function test_backed_value_is_the_php_type_token(): void
    {
        $this->assertSame('string', T::String->value);
        $this->assertSame('array', T::Array->value);
    }
}
